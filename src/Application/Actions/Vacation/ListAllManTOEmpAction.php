<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Setting\VacationModel AS SettingVacModel; 
use Psr\Http\Message\ResponseInterface as Response;


class ListAllManTOEmpAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $employee_id = $this->session->get("user_id");

        $os = EmployeeOSModel::getCurrentOSEmployeeByEmpId((int) $employee_id);
       
        $os_id = $os['result'][0]->os_id;
       

        $employee_list = EmployeeOSModel::getAllEmployeesUnderBox((int) $os_id);

        $vacation_types = SettingVacModel::all_vac_type();

       //dd( $employee_list);

        return $this->view->render(
            $this->response,
            'vacation/listManTOEmp.twig',
            [  'employee_list' => $employee_list['result'] , 'vacation_types' => $vacation_types['result'] ] ,
        );
    }


}
