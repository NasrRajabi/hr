<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;


use App\Models\Model;
use App\RequestValidators\JobAssignment\JobAssignmentRequestValidator;
use App\Application\Actions\Action;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Psr\Http\Message\ResponseInterface as Response;
class ListJopAssignmentSearchAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $startDate = $this->args['date1'];
        $endDate = $this->args['date2'];
        $sts = $this->args['sts'];

        $employee_id = $this->session->get("user_id");

       
            $list = JobAssignmentstoreModel::search($sts,$startDate,$endDate);
        

        return $this->view->render(
            $this->response,
            'job_assignment/list1.twig',
            [  'data' => $list['result'] ] ,
        );
    }
}
