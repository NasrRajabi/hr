<?php

declare(strict_types=1);

namespace App\Application\Actions\VacationsCrediting;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\VacationsCrediting\VacationsCreditingModel;

class AddVacationsCreditingAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        set_time_limit(0);
       $data= VacationsCreditingModel::all();

       $user_id=$this->session->get("user_id");
                
       $ye=VacationsCreditingModel::check_crediting();

            if($ye['rowCount'] == 0){
           
                    foreach ($data['result'] as $da) {
                        
                                $va=VacationsCreditingModel::emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type);
                                                             
                                if($va['rowCount'] == 0){
                                        if($da->gender==1 && $da->vacation_type != 4)
                                        {
                                            VacationsCreditingModel::insert_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type, $da->vac_days, $da->vac_days );
                                        }
                                        elseif($da->gender==2 && $da->vacation_type == 4 && $da->marital_status==2)
                                        {
                                            VacationsCreditingModel::insert_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type, $da->vac_days, $da->vac_days );
                                        }
                                        elseif($da->gender==1 && $da->vacation_type == 4 && $da->marital_status!=2)
                                        {
                                            goto start;
                                        }
                                        elseif($da->gender==2 && $da->vacation_type == 5 && $da->marital_status!=2)
                                        {
                                            goto start;
                                        }
                                        elseif($da->vacation_type == 3 && $da->religion!=1)
                                        {
                                            goto start;         
                                        }
                                        else
                                        {
                                            VacationsCreditingModel::insert_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type, $da->vac_days, $da->vac_days );
                                        }
                                        VacationsCreditingModel::insert_crediting($user_id);

                                }else{
                                   
                                    $cv=$va['result'][0]->current_balance;
                                    if($da->gender==1 && $da->vacation_type == 4)
                                    {
                                    VacationsCreditingModel::delete_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type);
                                    }
                                    elseif($da->gender==2 && $da->vacation_type == 4 && $da->marital_status==2)
                                    {
                                    VacationsCreditingModel::update_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type,$da->vac_days);
                                    }
                                    elseif($da->vacation_type == 1)
                                        {
                                                    if($cv + $da->vac_days > 60)
                                                    {
                                                        $cv=60;
                                                        VacationsCreditingModel::update_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type,$cv);
                                                    }
                                                    else
                                                    {
                                                        $cv=  $cv + $da->vac_days ; 
                                                        VacationsCreditingModel::update_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type,$cv);
                                                    }

                                        }
                                        elseif($da->vacation_type == 3 && $da->religion==1 && $cv==0)
                                        {
                                            VacationsCreditingModel::update_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type,0);
                                        }
                                        elseif($da->vacation_type == 3 && $da->religion==1 && $cv!=0)
                                        {
                                            VacationsCreditingModel::update_emp_vac_balance((int) $da->employee_id ,(int) $da->vacation_type,$cv);
                                        }
                                        elseif($da->vacation_type == 3 && $da->religion!=1)
                                        {
                                            goto start;         
                                        }
                                } 
                                start:
                            }
                            VacationsCreditingModel::insert_crediting($user_id);
                            die;

                            /*
                                    return $this->view->render(
                                        $this->response,
                                        'vacation/addEmpVacation.twig',   
                                        ['employee_id' => $employee_id],
                                    );
         
                                    */
        }                        
    }
}


    
