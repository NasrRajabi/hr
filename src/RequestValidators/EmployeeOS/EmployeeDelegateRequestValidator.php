<?php
declare(strict_types=1);
namespace App\RequestValidators\EmployeeOS;

use Valitron\Validator;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Models\Employee\EmployeeBasicInfoModel;

class EmployeeDelegateRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);
        $v->rule('required', ['c_employee_id', 'start_date', 'end_date', 'is_delegate']);

         // Check submitted 'emp_id' is valid 
         $v->rule(function ($field, $value, $params, $fields) {
            $employee = EmployeeBasicInfoModel::getEmpById((int)$value);
            if($employee["rowCount"] == 0)
            {
                return false;
            }
            return true;
        }, "c_employee_id")->message("The employee dose not exist");

        // TODO_Aya: check if this condition is correct
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