<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;

class ListEmpVacationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $employee_id = $this->session->get("user_id");
       // $employee_name =   $this->session->get('f_name').' '.$this->session->get('s_name').' '.$this->session->get('t_name').' '.$this->session->get('l_name');
      // dd($this->args);
        $list = VacationModel::getAllEmpVaction((int) $employee_id);

        return $this->view->render(
            $this->response,
            'vacation/listEmpVacation.twig',
            [  'list' => $list['result'] ] ,
        );
    }


}
