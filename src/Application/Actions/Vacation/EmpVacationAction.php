<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\Models\Setting\VacationModel AS SettingVacModel; 
use App\Models\Employee\EmployeeBasicInfoModel;

class EmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       // $employee_id = $this->session->get("user_id");

        $data = $this->request->getParsedBody();

        $employee_id = $data['employee_id'];

        $get_vac = VacationModel::getEmpVactionByVacId((int) $data['id'], (int) $employee_id);        

        $vacation_status = $this->lookups->get('vacation_status');

        $annual_vacation_type = $this->lookups->get('annual_vacation_type');

        
        $get_vac['result']->vac_type_name   = $get_vac['result']->vacation_name;
        $get_vac['result']->vac_sts         = $vacation_status[$get_vac['result']->vacation_status];        

        if($get_vac['result']->annual_vac_type != 0 ){
           // $get_vac['result']->vac_type_name   = $vacation_types[$get_vac['result']->vacation_type]. ' - ' . $annual_vacation_type[$get_vac['result']->annual_vac_type]; ;
           $get_vac['result']->vac_type_name  .=  ' - ' . $annual_vacation_type[$get_vac['result']->annual_vac_type];
        }   
    
      
        $get_vac['result']->approve_user_name = '' ;

        $get_approve_user = EmployeeBasicInfoModel::getEmpById((int) $get_vac['result']->approve_user);

        if($get_approve_user['rowCount'] !== 0 ) {
            $approve_user = $get_approve_user['result']->f_name.'  '.$get_approve_user['result']->l_name;
           
            $get_vac['result']->approve_user_name = $approve_user ;
        } 

        $get_create_user = EmployeeBasicInfoModel::getEmpById((int) $get_vac['result']->create_user);

        $create_user = $get_create_user['result']->f_name.'  '.$get_create_user['result']->l_name;
           
        $get_vac['result']->create_user_name = $create_user ;

        //$get_vac['result']->error = 'error' ;

        return $this->responseFormatter->asJson($this->response, $get_vac);

    }

}