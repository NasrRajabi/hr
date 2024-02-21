<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;


use App\Models\Model;
use App\RequestValidators\JobAssignment\JobAssignmentRequestValidator;
use App\Application\Actions\Action;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Psr\Http\Message\ResponseInterface as Response;
class DecisionJobAssignmentAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       $dec=$this->args['dec'];
       $id=$this->args['id'];
       $user=$this->session->get("user_id");
       $date=date("Y-m-d")   ;
        JobAssignmentstoreModel::updatedecJobAssigment($dec,$user,$date,$id);
        return $this->response
        ->withHeader('Location', '/job_assignment/list.twig')
        ->withStatus(302);
        
    }
}