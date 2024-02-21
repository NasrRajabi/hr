<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Setting\VacationModel AS SettingVacModel; 
use Psr\Http\Message\ResponseInterface as Response;


class ListManTOEmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $employee_id = $this->args['empID'];

        $list = VacationModel::getAllEmpVaction((int) $employee_id);

        $vacation_types = SettingVacModel::all_vac_type();

        return $this->view->render(
            $this->response,
            'vacation/listManTOEmpVacation.twig',
            [  'vacation_list' => $list['result'], 'vacation_types' => $vacation_types['result']  ] ,
        );
    }


}
