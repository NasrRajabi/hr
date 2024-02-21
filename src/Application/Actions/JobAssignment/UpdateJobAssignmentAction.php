<?php

declare(strict_types=1);

namespace App\Application\Actions\JobAssignment;


use App\Models\Model;
use App\RequestValidators\JobAssignment\JobAssignmentRequestValidator;
use App\Application\Actions\Action;
use App\Models\JobAssignment\JobAssignmentstoreModel;
use Psr\Http\Message\ResponseInterface as Response;
class UpdateJobAssignmentAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        JobAssignmentstoreModel::updateJobAssigment($this->args);
        return $this->response
        ->withHeader('Location', '/job_assignment/list.twig')
        ->withStatus(302);
        
    }
}