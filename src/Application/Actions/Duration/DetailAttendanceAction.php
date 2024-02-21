<?php

declare(strict_types=1);

namespace App\Application\Actions\Duration;

use DateTime;
use App\Models\Model;
use App\RequestValidators\Duration\DurationRequestValidator;
use App\Application\Actions\Action;
use App\Models\Duration\DurationListModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\AttendanceAgreements\AgreementModel;
    class DetailAttendanceAction extends Action
    {
    
    
        /**
         * {@inheritdoc}
         */
        protected function action(): Response 
        {

/*
            $leave_types = $this->lookups->get('leave');
            $vacation_status = $this->lookups->get('vacation_status');
            $vacation_types = $this->lookups->get('vacation_type');   
            $status_class = $this->lookups->get('status_class');
    */
    $DurationListModel = new DurationListModel();
    $id = $this->args["id"];
        $data = $DurationListModel->find( (int) $id);
        
        $i=0 ;
        foreach($data['result'] as $value){
          
                   
                    $check=new DateTime($data['result'][$i]->check_in) ;
                    $check_in=$check->format("h:i");
                    $dateTime = new DateTime($data['result'][$i]->date);
                    $dayName = $dateTime->format('D');
                    
                    
                    $AgreementDetial = AgreementModel::getEmpAttendenceAgreement((int) $data['result'][$i]->id, (string) $dayName);
                    $start_time = $AgreementDetial['result']->start_time;
                    $end_time = $AgreementDetial['result']->end_time;
                    $time1 = $start_time;
                    $time2 = $check_in;
                    $array1 = explode(':', $time1);
                    $array2 = explode(':', $time2);
                
                    $minutes1 = ($array1[0] * 60.0 + $array1[1]);
                    $minutes2 = ($array2[0] * 60.0 + $array2[1]);
                
            $diff = $minutes1 - $minutes2;
            if($diff < 0){
                $diff=$diff * -1 ;
            }else{
                $diff='--';
            }
            $data['result'][$i]->{"diff"}= $diff ;
                  
                    $check_o=new DateTime($data['result'][$i]->check_out) ;
                    $check_out=$check_o->format("H:i");
                    $time3 = $end_time;
                    $time4 = $check_out;
                    $array3 = explode(':', $time3);
                    $array4 = explode(':', $time4);
                
                    $minutes3 = ($array3[0] * 60.0 + $array3[1]);
                    $minutes4 = ($array4[0] * 60.0 + $array4[1]);
                
            $diff_out = $minutes3 - $minutes4;
            if($diff_out > 0){
                           
            $data['result'][$i]->{"diff_out"}= $diff_out ;
                    }
                  
$i++;
                }
                
        //dd( $data);
               return $this->view->render(
                $this->response,
                
                'duration/detail.twig',['data'=>$data['result'] ]
            );
            
        }
    }
    