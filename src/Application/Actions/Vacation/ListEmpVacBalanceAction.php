<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;

class ListEmpVacBalanceAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
 
        $employee_id = $this->session->get("user_id");

        $list = VacationModel::getEmpbalance((int) $employee_id);

        return $this->view->render(
            $this->response,
            'vacation/listEmpVacBalance.twig',
            [ 'list' => $list['result']] ,
        );
    }


}
