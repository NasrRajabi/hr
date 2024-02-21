<?php

declare(strict_types=1);

namespace App\Application\Actions\Leave;


use App\Models\Model;
use App\RequestValidators\Leave\LeaveRequestValidator;
use App\Application\Actions\Action;
use App\Models\Leave\LeaveListModel;
use Psr\Http\Message\ResponseInterface as Response;
    
    class ListLeaveAction extends Action
    {
    
    
        /**
         * {@inheritdoc}
         */
        protected function action(): Response
        {

            $leave_types = $this->lookups->get('leave');
            $vacation_status = $this->lookups->get('vacation_status');
            $vacation_types = $this->lookups->get('vacation_type');   
            $status_class = $this->lookups->get('status_class');
    
            $LeaveListModel = new LeaveListModel();
            $data=$LeaveListModel->all();
            // echo $leave_types[1] ;
         //print_r ($data['result'][0]->leave_start);
    
         $d=count($data['result']);
          $i=0;
         foreach($data['result'] as $value){
          
          $time1 = $value->leave_end;
          $time2 = $value->leave_start;
          $array1 = explode(':', $time1);
          $array2 = explode(':', $time2);
      
          $minutes1 = ($array1[0] * 60.0 + $array1[1]);
          $minutes2 = ($array2[0] * 60.0 + $array2[1]);
      
           $diff = $minutes1 - $minutes2;
          
           $value->{"diff"}= $diff ;

         }
         //dd($data);
               return $this->view->render(
                $this->response,
                'leave/list.twig',['data'=>$data['result'] ,'leave_types' => $leave_types,'vacation_status'=>$vacation_status,'vacation_types'=>$vacation_types,'status_class'=>$status_class]
            );
        }
    }
    