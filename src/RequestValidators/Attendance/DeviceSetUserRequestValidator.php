<?php

declare(strict_types=1);

namespace App\RequestValidators\Attendance;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class DeviceSetUserRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['employee_no', 'role', 'device_ip']);
        $v->rule('ip', 'device_ip');

        $v->rule(function ($field, $value, $params, $fields) {
            $user = $this->UserProviderService->getByCredentials(['employee_no' => (int) $value]);
            if ($user['rowCount'] == 1) {
                return true;
            }
            return false;
        }, "employee_no")->message("الرقم الوظيفي المدخل غير موجود");

        $v->labels(array(
            'employee_no' => 'الرقم الوظيفي',
            'device_ip' => 'IP',
            'role' => 'الصلاحية',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
