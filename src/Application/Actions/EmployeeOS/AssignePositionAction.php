<?php

declare(strict_types=1);

namespace App\Application\Actions\EmployeeOS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Role\RoleModel;
use App\Models\Job\JobModel;

class AssignePositionAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $empty_os = EmployeeOSModel::getAllEmptyOS();
        $roles = RoleModel::all();
        $job_list = JobModel::all();

        return $this->view->render(
            $this->response,
            'employee/assignOS.twig', ['empty_os' => $empty_os['result'], 'emp_no' => $this->args["no"], 'job_list' => $job_list['result'], 'roles' => $roles['result']]
        );
    }
}