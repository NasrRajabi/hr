<?php

declare(strict_types=1);

namespace App\Application\Actions\Vacation;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Vacation\VacationModel;

class ListEmpVacationSearchAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
    //dd( $this->args);

        $startDate = $this->args['date1'];
        $endtDate = $this->args['date2'];
        $sts = $this->args['sts'];

        $employee_id = $this->session->get("user_id");

        if ($sts == "null"){
            $list = VacationModel::getEmpVactionSearchAllSts((int) $employee_id, (int) $sts, $startDate, $endtDate);
        }else{
            $list = VacationModel::getEmpVactionSearch((int) $employee_id, (int) $sts, $startDate, $endtDate);
        }

        return $this->view->render(
            $this->response,
            'vacation/listEmpVacation.twig',
            [  'list' => $list['result'] ] ,
        );
    }


}
