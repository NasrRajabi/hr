<?php

declare(strict_types=1);

namespace App\Application\Actions\Duration;

use App\Models\Employee\EmployeeOSModel;
use DateTime;
use App\Models\Model;
use App\RequestValidators\Duration\DurationRequestValidator;
use App\Application\Actions\Action;
use App\Models\Duration\DurationListModel;

use Psr\Http\Message\ResponseInterface as Response;
use App\Models\AttendanceAgreements\AgreementModel;

class ListAttendanceAction extends Action
{

    protected function action(): Response 
    {
        $DurationListModel = new DurationListModel();
        // $data = $DurationListModel->all();

        $data = $DurationListModel->all_with_os(); 
        // dd($os);
    
        foreach ($data['result'] as &$value) {
            $this->calculateCheckInDiff($value);
            $this->calculateCheckOutDiff($value);
        }
    
//         $AgreementDetial = AgreementModel::getEmpAttendenceAgreement(
//             (int) $data['result'][0]->id,
//             (string) $data['result'][0]->date
//         );
//   dd($data);
        return $this->view->render(
            $this->response,
            'duration/view.twig',
            ['data' => $data['result'] ]
           
        );
    }
    
    private function calculateCheckInDiff(&$value) {
        if ($value->check_in !== null ) {
            $check = new DateTime($value->check_in);
            $check_in = $check->format("H:i");
            $dateTime = new DateTime($value->date);
            $dayName = $dateTime->format('D');
            
            $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $value->id, $dayName);
           // dd($AgreementDetial);
            $start_time = $AgreementDetial['result']->start_time;
    
            $minutes1 = $this->convertToMinutes($start_time);
            $minutes2 = $this->convertToMinutes($check_in);
    
            $value->diff = (int) $minutes1 - (int) $minutes2;
            $value->att_hours=(int) $AgreementDetial['result']->end_time - (int)  $AgreementDetial['result']->start_time - (int) $AgreementDetial['result']->allowed_p_leave_hours;

 $value->ag= $AgreementDetial['result'];
        
        }
    }
    
    private function calculateCheckOutDiff(&$value) {
        if ($value->check_out !== null ) {
            $check = new DateTime($value->check_out);
            $check_out = $check->format("H:i");
            
           
            $dateTime = new DateTime($value->date);
            $dayName = $dateTime->format('D');
    
            $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $value->id, $dayName);
            $end_time = new DateTime($AgreementDetial['result']->end_time);
    
            $minutes1 = $this->convertToMinutes($end_time->format("H:i"));
            $minutes2 = $this->convertToMinutes($check_out);
    
            $value->diff_out = (int) $minutes2 - (int) $minutes1;
             if ($value->check_in !== null ) {
            $check_in = new DateTime($value->check_in);
            $interval = $check->diff($check_in);
            $value->att_hours = $interval->h;
             }
            $value->min_att_hours=(int) $AgreementDetial['result']->end_time - (int)  $AgreementDetial['result']->start_time - (int) $AgreementDetial['result']->allowed_p_leave_hours;

 $value->ag= $AgreementDetial['result'];
        }
    }
    
 
    private function convertToMinutes($time) {
        [$hours, $minutes] = explode(':', $time);
        return ($hours * 60.0 + $minutes);
    }
    
}
