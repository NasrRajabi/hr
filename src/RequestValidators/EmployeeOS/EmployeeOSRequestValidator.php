<?php
declare(strict_types=1);
namespace App\RequestValidators\EmployeeOS;

use Valitron\Validator;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class EmployeeOSRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);
        $v->rule('required', ['c_os_id', 'c_employee_id', 'start_date', 'is_delegate', 'c_role_id']);

        $v->rule(function ($field, $value, $params, $fields) {
          
            if ($fields['end_date'] != null && ($fields['end_date'] <= $value)) {
                return false;
            }
            return true;
        }, "start_date")->message("خطأ في ادخال التواريخ");

        
        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}