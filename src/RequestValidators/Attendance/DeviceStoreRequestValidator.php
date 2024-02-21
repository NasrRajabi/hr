<?php

declare(strict_types=1);

namespace App\RequestValidators\Attendance;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class DeviceStoreRequestValidator  implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['name', 'device_ip', 'area']);

        
        $v->rule('required', ['name', 'device_ip', 'area']);
          $v->rule('ip', 'device_ip');

        $v->rule('subset', 'area', array_keys($this->lookups->get('city')));


        $v->labels(array(
            'name' => 'اسم الساعة ',
            'device_ip' => 'IP Adress ',
            'area' => 'المنطقة '
           
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }


        return $data;
    }
}
