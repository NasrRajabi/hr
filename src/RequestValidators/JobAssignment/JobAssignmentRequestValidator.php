<?php

declare(strict_types=1);

namespace App\RequestValidators\JobAssignment;

use PDO;
use Valitron\Validator;
use DateTime;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Options;

class JobAssignmentRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
     
        $v = new Validator($data);

        $v->rule('required', ['mission_start_date', 'mission_end_date']);
       
        //$v->rule('integer', ['employee_id']);  , ['mission_type']
        $v->rule('integer', array_keys($this->lookups->get('job_assignment_type')));
        
/******************************************************************************************************************** */
$v->rule(function ($field, $value, $params, $fields) {
           
    if ( $fields['mission_type'] == "null") {
        return false;
    }
    
    return true;
}, "mission_type")->message("يجب ادخال نوع المهمه");  
/******************************************************************************************************************** */
/*
$v->rule(function ($field, $value, $params, $fields) {
           
    if ( $fields['employee_id'] == "null") {
        return false;
    }
    
    return true;
}, "employee_id")->message("يجب ادخال موظف للمهمه");  
//******************************************************************************************************************* */
$v->rule(function ($field, $value, $params, $fields) {
    $dateTime = new DateTime($fields['mission_start_date']);
     $dayName = $dateTime->format("Y");   
    if (date( $dayName) < date("Y")){
        return false;
    }
    return true;
}, "mission_start_date")->message("خطأ في ادخال التاريخ");
//************************************************************************************************************************ */
if($data['mission_type'] ==1){
if ($data['mission_type'] != null  && $data['employee_id'] != null  && $data['mission_start_date'] != ""  && $data['mission_end_date'] != "") {
$v->rule(function ($field, $value, $params, $fields) {
        $leave = JobAssignmentstoreModel::check($fields);

        if ( $leave['rowCount'] > 0) {
            return false;
        }
        return true;
        
    }, "mission_end_date")->message("المهمه المدخله  تتعارض مع مهمه مدخله ");
}
} /*elseif($data['mission_type'] ==2){
    if ($data['mission_type'] != null   && $data['mission_start_date'] != ""  && $data['mission_end_date'] != "") {
        $v->rule(function ($field, $value, $params, $fields) {
                $leave = JobAssignmentstoreModel::check_out($fields);
        
                if ( $leave['rowCount'] > 0) {
                    return false;
                }
                return true;
                
            }, "mission_end_date")->message("المهمه المدخله  تتعارض مع مهمه مدخله ");
        } 
}*/
//******************************************************************************************************************** 
$v->rule(function ($field, $value, $params, $fields) {
    $dateTime = new DateTime($fields['mission_end_date']);
     $dayName = $dateTime->format("Y");   
    if (date( $dayName) < date("Y")){
        return false;
    }
    return true;
}, "mission_end_date")->message("خطأ في ادخال التاريخ");


//*************************************************************************************************** */
$v->labels(array(
    'mission_type' => 'نوع المهمه',
    'mission_start_date' => 'وقت بدء المهمه',
    'end_date' => 'وقت انتهاء المهمه',  
    'employee_id' => "يجب ادخال موظف للمهمه",
));

if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }
       
        return $data;
    }
}
