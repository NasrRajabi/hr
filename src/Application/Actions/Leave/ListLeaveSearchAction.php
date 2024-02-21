<?php

declare(strict_types=1);

namespace App\Application\Actions\Leave;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Leave\LeaveListModel;

class ListLeaveSearchAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
    //dd( $this->args);
        $leave_types = $this->lookups->get('leave');
        $vacation_status = $this->lookups->get('vacation_status');
        $vacation_types = $this->lookups->get('vacation_type');   
        $status_class = $this->lookups->get('status_class');
        $leave_type = $this->args['leave_type'];
        $start_date = $this->args['start_date'];
        $end_date = $this->args['end_date'];
        $sts = $this->args['sts'];
        
        $employee_id = $this->session->get("user_id");
        if(($sts == "null") && ($start_date != "null") && ($end_date != "null") && ($leave_type != "null")) {
           
            $list = LeaveListModel::getLeaveBydateType( $start_date,$end_date, $leave_type); 

        }else if (($sts == "null") && ($leave_type=="null") && ($start_date != "null") && ($end_date != "null")){
            $list = LeaveListModel::getLeaveByTowDate($start_date,$end_date);

        }else if (($sts == "null") && ($leave_type=="null") && ($end_date=="null") && ($start_date != "null")){
            $list = LeaveListModel::getLeaveBydate($start_date);
        }else  if($sts != "null") {
            $list = LeaveListModel::getLeaveStatusdateType($sts); 
            
        }
        
        $time1 = $list['result'][0]->leave_end;
        $time2 = $list['result'][0]->leave_start;
        $array1 = explode(':', $time1);
        $array2 = explode(':', $time2);
    
        $minutes1 = ($array1[0] * 60.0 + $array1[1]);
        $minutes2 = ($array2[0] * 60.0 + $array2[1]);
    
         $diff = $minutes1 - $minutes2;
        
         $list['result'][0]->{"diff"}= $diff ;

        return $this->view->render(
            $this->response,
            'leave/list.twig',
            ['data'=>$list['result'] ,'leave_types' => $leave_types,'vacation_status'=>$vacation_status,'vacation_types'=>$vacation_types,'status_class'=>$status_class] ,
        );
    }


}
