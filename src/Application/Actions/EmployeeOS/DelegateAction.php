<?php

declare(strict_types=1);

namespace App\Application\Actions\EmployeeOS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Auth\AuthModel;
use App\Models\Employee\EmployeeModel;

class DelegateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // get all user permissions
        $permissions = AuthModel::getPermissions($this->session->get("user_role"));

        // get all employees under user's box
        $all = EmployeeOSModel::getAllEmployeesUnderBox($this->session->get("os_id"));    

        $employees = array_unique(array_map(function($o) { return ['emp_id' => $o->emp_id."_".$o->employee_no, 'name' => $o->f_name." ".$o->l_name];}, $all['result']), SORT_REGULAR);

        $employee_name = "";
        $query = $this->request->getQueryParams();
        if(count($query) > 0) {            
            $employee_name = EmployeeModel::getEmployeeBaseInfo((int)$query["no"]);  
            $employee_name = $employee_name["result"][0]->f_name . " ". $employee_name["result"][0]->l_name ;
        }

        return $this->view->render(
            $this->response,
            'Employee/delegate.twig', ['rolePermissions' => $permissions['result'], 'employees' => $employees, 'employee_name' => $employee_name]
        );
    }
}