<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;

class AddEmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $employee_id = $this->session->get("user_id");

        return $this->view->render(
            $this->response,
            'vacation/addEmpVacation.twig',   
            ['employee_id' => $employee_id],
        );
    }


}
