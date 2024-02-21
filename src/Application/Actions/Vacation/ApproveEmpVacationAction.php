<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;
use App\RequestValidators\Vacation\VacationRequestValidator;

class ApproveEmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      //  dd($this->args);
       
       $vacation_id = $this->args['id'];
       $vacation_status = $this->args['sts'];

       if ($vacation_status == 3 || $vacation_status == 4) {
            $get_vac = VacationModel::getVaction((int) $vacation_id);
            
            $employee_id = $get_vac['result']->employee_id;
            $vacation_type = $get_vac['result']->vacation_type;

            $startDate = new DateTime($get_vac['result']->start_date);
            $endtDate = new DateTime($get_vac['result']->end_date);
            $vac_days = (date_diff($startDate, $endtDate)->format("%a")) + 1 ;        

            VacationModel::returnEmpVacCurrentBal((int) $vac_days, (int) $employee_id, (int) $vacation_type);

       }

       $employee_id = $this->session->get("user_id");

       VacationModel::approveEmpVacation((int) $vacation_status, (int) $employee_id, date('Y-m-d H:i:s'), (int) $vacation_id );
             
        return $this->response
        ->withHeader('Location', '/vacation/listEmpVacation')
        ->withStatus(302);
    }

}
