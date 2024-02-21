<?php

declare(strict_types=1);

namespace App\RequestValidators\Attendance;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class DeviceCheckConnectRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', 'device_ip');
        $v->rule('ip', 'device_ip');

       
        $v->labels(array(
            'device_ip' => 'IP',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
