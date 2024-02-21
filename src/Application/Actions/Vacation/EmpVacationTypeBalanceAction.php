<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;

class EmpVacationTypeBalanceAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $employee_id = $this->session->get("user_id");

        $data = $this->request->getParsedBody();
     
        $get_emp_balance = VacationModel::getEmpbalanceByVacType((int) $data['vacation_type'], (int) $employee_id);

       return $this->responseFormatter->asJson($this->response, $get_emp_balance);

    }

}