<?php

declare(strict_types=1);

namespace App\RequestValidators\Leave;

use PDO;
use Valitron\Validator;
use DateTime;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Models\Leave\LeaveAddModel;
use App\Models\AttendanceAgreements\AgreementModel;
class LeaveRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
      //dd($data);
        $v = new Validator($data);

        $v->rule('required', ['employee_id','leave_type', 'leave_date', 'leave_start', 'leave_end']);
        $v->rule('integer', ['employee_id']);
        $v->rule('integer', ['leave_type'], array_keys($this->lookups->get('leave')));
/******************************************************************************************************************** */
$v->rule(function ($field, $value, $params, $fields) {
           
    if ( $fields['leave_type'] == "null") {
        return false;
    }
    return true;
}, "leave_type")->message("يجب ادخال نوع المغادره");  
//******************************************************************************************************************* */
$v->rule(function ($field, $value, $params, $fields) {
    $dateTime = new DateTime($fields['leave_date']);
     $dayName = $dateTime->format('Y');   
    if (date( $dayName) < date("Y")){
        return false;
    }
    return true;
}, "leave_date")->message("خطأ في ادخال التاريخ");

//******************************************************************************************************************** */
$v->rule(function ($field, $value, $params, $fields) {
    
        $leave = LeaveAddModel::check($fields);
   
    if ( $leave['rowCount'] > 0) {
        return false;
    }
    return true;
}, "leave_end")->message("الاوقات المدخله للمغادره تتعارض مع مغادره مقدمه ");
//******************************************************************************************************************* */
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
//******************************************************************************************** */
$v->rule(function ($field, $value, $params, $fields) {
    
   // $leave = LeaveAddModel::check($field);
    $dateTime = new DateTime($fields['leave_date']);
    $dayName = $dateTime->format('D'); 
    
    $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $fields['employee_id'], (string) $dayName);
//**************************************************************************************************************** */
switch ($fields['leave_start']) {
    case $fields['leave_start']< $AgreementDetial['result']->start_time :
    
        return false;
        break;
    case $fields['leave_start'] >$AgreementDetial['result']->end_time:
        return false;
        break;
    case $fields['leave_end'] < $AgreementDetial['result']->start_time:
        return false;
        break;
        case $fields['leave_end'] > $AgreementDetial['result']->end_time:
            return false;
            break;
    default:
       
        break;
}
  //*************************************************************************************************************** */ 
 
return true;
}, "leave_end")->message("  الاوقات المدخله للمغادره تتعارض مع بداية او نهاية الدوام  ");
//*************************************************************************************************** */
$v->labels(array(
    'leave_type' => 'نوع المغادره',
    'leave_start' => 'وقت بدء المغادره',
    'leave_end' => 'وقت انتهاء المغادره',  
    'leave_date' => 'تاريخ المغادره',
));

if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
