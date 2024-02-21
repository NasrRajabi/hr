<?php

declare(strict_types=1);

namespace App\Application\Actions\Employee;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Employee\EmployeeBasicInfoModel;
use App\Models\Employee\EmployeeModel;
use App\Models\Job\JobModel;
use App\Models\Os\OsModel;

class ViewAllEmployeesAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {


        /// المسميات الوظيفية 
        $jobs = JobModel::all();
        $os = OsModel::all(); 

        $all = EmployeeModel::all_with_os_position();

        // dd($all);



        return $this->view->render(
            $this->response,
            'employee/view.twig',
            ['data' => $all['result'], 'jobs' => $jobs['result'] , 'os' => $os['result']],
        );
    }
}
