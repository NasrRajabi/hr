<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Leave\LeaveListModel;
class AddJobAssignmentAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $LeaveListModel= new LeaveListModel();
        $data=$LeaveListModel->allempindept();
        return $this->view->render(
            $this->response,
            'job_assignment/add.twig',['data'=>$data['result']]
        );
    }
}
