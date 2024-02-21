<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;

class ManTOEmpVacBalAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
        $data = $this->request->getParsedBody();
        //dd($data);
     
        $get_emp_balance = VacationModel::getEmpbalanceByVacType((int) $data['vacation_type'], (int) $data['employee_id']);

       return $this->responseFormatter->asJson($this->response, $get_emp_balance);

    }

}