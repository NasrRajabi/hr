<?php

declare(strict_types=1);

namespace App\RequestValidators\Agreements;

use PDO;
use DateTime;

use Valitron\Validator;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

use App\Contracts\UserProviderServiceInterface;
use App\Models\AttendanceAgreements\AgreementModel;


class AgreementDetailsRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {


        $v = new Validator($data);

        foreach ($this->lookups->get('days') as $key => $day) {

            if ((int) $data[$key . '_att_status'] === 3) {

                $v->rule('required', [
                    $key . '_att_status',
                    $key . '_day',
                    $key . '_start_time',
                    $key . '_end_time',
                    $key . '_check_in_end',
                    $key . '_allowed_time_check_in',
                    $key . '_allowed_time_check_out',
                    $key . '_allowed_p_leave_hours'
                ]);

                $v->rule('subset', $data[$key . '_att_status'], array_keys($this->lookups->get('att_status')));

                $v->rule('numeric', [
                    $key . '_allowed_time_check_in',
                    $key . '_allowed_time_check_out',
                    $key . '_allowed_p_leave_hours'
                ]);

                # فحص بداية الدوام بالنسبة لنهايته 
                $v->rule(function ($field, $value, $params, $fields) use ($key) {

                    $endTime = $fields[$key . '_end_time'];
                    return $endTime > $value;
                }, $key . '_start_time')->message("وقت بداية الدوام يجب ان يكون اقل من وقت انتهاء الدوام");


                #فحص  اخر الوقت المسموح للدخول
                $v->rule(function ($field, $value, $params, $fields) use ($key) {

                    $startTime = $fields[$key . '_start_time'];
                    $endTime = $fields[$key . '_end_time'];

                    return $startTime < $value && $value  < $endTime;
                }, $key . '_check_in_end')->message("آخر وقت مسموح لاحتساب بصمات الدخول يجب أن يكون أكبر من وقت بداية الدوام وأقل من وقت نهاية الدوام");

                # فحص  الحد الأدنى قيمة الوقت المسمحوح في التأخير والانصراف 
                $v->rule('min', [
                    $key . '_allowed_time_check_in',
                    $key . '_allowed_time_check_out',
                    $key . '_allowed_p_leave_hours'
                ], 0)->message('الرقم يحب أن يكون أكبر من 0');

                # فحص  الحد الأعلى قيمة الوقت المسمحوح في التأخير والانصراف 
                $v->rule('max', [
                    $key . '_allowed_time_check_in',
                    $key . '_allowed_time_check_out'
                ], 60)->message('أكبر قيمة لوقت السماح أقل من 60 دقيقة');



                #  فحص الحد الأعلى للمغادرات الخاصة
                $v->rule(function ($field, $value, $params, $fields) use ($key) {


                    $startTime = $fields[$key . '_start_time'];
                    $endTime = $fields[$key . '_end_time'];


                    $startDateTime = DateTime::createFromFormat('H:i:s', $startTime);
                    $endDateTime = DateTime::createFromFormat('H:i:s', $endTime);

                    
                    $interval = $startDateTime->diff($endDateTime);
                    $diffInHours = $interval->h;
                    // dd($interval);
                    return  $diffInHours > $value;
                }, $key . '_allowed_p_leave_hours')->message("الحد الأعلى لساعات المغادرات يجب أن يكون أقل من ساعات الدوام المعتمدة ");
            }

            else {
          
             
               $data[ $key . '_start_time'] = date('H:i:s', strtotime('00:00:00'));
               $data[ $key . '_end_time'] ="00:00:00";
               $data[ $key . '_check_in_end'] ="00:00:00";
               $data[ $key . '_allowed_time_check_in'] = 0;
               $data[ $key . '_allowed_time_check_out'] = 0;
               $data[ $key . '_allowed_p_leave_hours'] = 0;


            }


            #
            $v->labels(array(
                $key . '_start_time' => 'بداية الدوام ',
                $key . '_end_time' => 'نهاية الدوام  ',
                $key . '_check_in_end' => 'نهاية الوقت لاحتساب بصمة الدخول ',
                $key . '_allowed_time_check_in' =>  'الوقت المسموح للتأخير الصباحي ',
                $key . '_allowed_time_check_out' => ' الوثت المسموح للانصراف المبكر',
                $key . '_allowed_p_leave_hours' => 'الحد الأعلى لساعات المغادرات الخاصة',
            ));
        }



        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
