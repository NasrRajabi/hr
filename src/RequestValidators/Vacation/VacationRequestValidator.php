<?php

declare(strict_types=1);

namespace App\RequestValidators\Vacation;

use PDO;
use Valitron\Validator;
use DateTime;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Models\Vacation\VacationModel;
use App\Models\AttendanceAgreements\AgreementModel;


class VacationRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['vacation_type', 'start_date', 'end_date']);
        $v->rule('lengthMin', 'mobile', 10);

        $v->rule('subset', 'vacation_type', array_keys($this->lookups->get('vacation_type')));
        $v->rule('subset', 'vacation_status', array_keys($this->lookups->get('vacation_status')));
        $v->rule('subset', 'annual_vacation_type', array_keys($this->lookups->get('annual_vacation_type')));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $v->rule(function ($field, $value, $params, $fields) {
          
            if ($value > $fields['end_date'] ) {
                return false;
            }
            return true;
        }, "start_date")->message("خطأ في ادخال التواريخ");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $v->rule(function ($field, $value, $params, $fields) {
        
            if ($value < date("Y-m-d") ) {
                return false;
            }
            return true;
        }, "start_date")->message("خطأ في تاريح البداية");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $v->rule(function ($field, $value, $params, $fields) {

            $vac_balance = VacationModel::getEmpbalanceByVacType((int) $fields['vacation_type'], (int) $fields['employee_id']);
            $current_balance = $vac_balance['result']->current_balance;

            $date1 = date_create($fields['start_date']);
            $date2 = date_create($fields['end_date']);
            $day_count = (date_diff($date1,$date2)->format("%a")) + 1 ;

            if ($current_balance < $day_count ) {
                return false;
            }
            return true;
        }, "current_balance")->message("الرصيد اقل من عدد ايام الاجازة");    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $v->rule(function ($field, $value, $params, $fields) {
            if (!empty($fields['id']) ){
                $vacations = VacationModel::getEditEmpDuplicateVac((int) $fields['employee_id'], $fields['start_date'], $fields['end_date'], (int) $fields['id']);
            }else{
                $vacations = VacationModel::getEmpDuplicateVac((int) $fields['employee_id'], $fields['start_date'], $fields['end_date']);
            }
            if ($vacations['rowCount'] >= 1) {
                return false;
            }
            return true;
        }, "start_date")->message("تاريخ الاجازة متعارض مع اجازة سابقة");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $v->rule(function ($field, $value, $params, $fields) {
           
                // الرصيد السنوي يجب ان يكون صفر لادخال اجازة عارضة
               
                $vac_balance = VacationModel::getEmpbalanceByVacType((int) 1 , (int) $fields['employee_id']);
                $current_balance = $vac_balance['result']->current_balance;
    
            if ($current_balance != 0 && $fields['vacation_type'] == 6) {
                return false;
            }
            return true;
        }, "vacation_type")->message("لا يمكن ادخال اجازة عارضة، الرصيد السنوي للموظف أكبر من صفر");    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $v->rule(function ($field, $value, $params, $fields) {
           
            if ( $value == "null" && $fields['vacation_type'] == 1) {
                return false;
            }
            return true;
        }, "annual_vac_type")->message("يجب ادخال سبب الأجازة");    
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
        $v->rule(function ($field, $value, $params, $fields) {
           
           // ادخال الاجازة غير متوافق مع العطل الرسمية في اتفاقية الدوام
            
            $dateTime = new DateTime($fields['start_date']);
            $dayName = $dateTime->format('D'); 

            $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $fields['employee_id'], (string) $dayName);
            $att_status = $AgreementDetial['result']->att_status;

            if ($att_status === 5) { // عطلة اسبوعية رسمية
                return false;            
            }

        return true;
    }, "start_date")->message("تاريخ بداية الاجازة يوم عطلة رسمية");    

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     

    $v->rule(function ($field, $value, $params, $fields) {
            
        // ادخال الاجازة غير متوافق مع العطل الرسمية في اتفاقية الدوام
        
        $dateTime = new DateTime($fields['end_date']);
        $dayName = $dateTime->format('D'); 

        $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $fields['employee_id'], (string) $dayName);
        $att_status = $AgreementDetial['result']->att_status;

        if ($att_status === 5) { // عطلة اسبوعية رسمية
            return false;            
        }

    return true;
    }, "end_date")->message("تاريخ نهاية الاجازة يوم عطلة رسمية");    

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
        $v->labels(array(
            'vacation_type' => 'نوع الاجازة',
            'start_date' => 'تاريخ بدء الاجازة',
            'end_date' => 'تاريخ انتهاء الاجازة',  
            'mobile' => 'رقم المحمول',
            'phone' =>  'رقم الهاتف',
            'current_balance' => 'الرصيد الحالي',
            'annual_vac_type' => 'سبب الأجازة',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
