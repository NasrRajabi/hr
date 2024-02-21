<?php

declare(strict_types=1);

namespace App\RequestValidators\Duration;

use PDO;
use Valitron\Validator;
use DateTime;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;
//use App\Models\Leave\LeaveAddModel;
use App\Models\AttendanceAgreements\AgreementModel;
class DurationRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
      
        $v = new Validator($data);
/*
        $v->rule('required', ['employee_id','leave_type', 'leave_date', 'leave_start', 'leave_end']);
        $v->rule('integer', ['employee_id']);
        $v->rule('integer', ['leave_type'], array_keys($this->lookups->get('leave')));

//******************************************************************************************************************* 
/*
$v->rule(function ($field, $value, $params, $fields) {
           
   
     
     $dateTime = new DateTime($fields['leave_date']);
     $dayName = $dateTime->format('D'); 

     $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $fields['employee_id'], (string) $dayName);
     $att_status = $AgreementDetial['result']->att_status;

     if ($att_status === 5) { // عطلة اسبوعية رسمية
         return false;            
     }

 return true;
}, "leave_date")->message("تاريخ المغادره يوم عطلة رسمية");
*/

  //*************************************************************************************************************** */ 
 

if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
