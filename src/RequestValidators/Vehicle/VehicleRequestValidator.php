<?php

declare(strict_types=1);

namespace App\RequestValidators\Vehicle;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class VehicleRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['vehicle_no', 'vehicle_name', 'vehicle_type', 'chassis_no', 'engine_no', 'engine_capacity', 'vehicle_model', 'fuel_type', 'lime_type', 'vehicle_color']);

  
        $v->labels(array(
            'vehicle_no' => 'رقم المركبة',
            'vehicle_name' => 'اسم المركبة',
            'vehicle_type' => 'نوع المركبة',
            'chassis_no' => 'رقم الشاصي',
            'engine_no' => 'رقم المحرك',
            'engine_capacity' => 'سعة المحرك',
            'vehicle_model' => 'موديل المركبة',
            'fuel_type' => 'نوع الوقود',
            'lime_type' => 'نوع الجير',
            'vehicle_color' => 'لون المركبة',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
