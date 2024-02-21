<?php

declare(strict_types=1);

namespace App\Application\Actions\OS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Os\OsModel;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Employee\EmployeeBasicInfoModel;
use App\RequestValidators\EmployeeOS\EmployeeOSRequestValidator;

class AssignOSViewAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hasError = false;
        $data = $this->requestValidatorFactory->make(EmployeeOSRequestValidator::class)->validate($this->request->getParsedBody());
        
        // TODO_AYA: move the validations to the EmployeeOSRequestValidator
        // Check submitted 'os_id' is valid 
        $all = OsModel::all();
        $os_ids = array_column($all['result'], 'id');
        if(!in_array( $data["c_os_id"] ,$os_ids ) )
        {
            $hasError = true;
            $this->msgError(error: "The department dose not exist");
        }

        // Check submitted 'emp_no' is valid 
        $employee = EmployeeBasicInfoModel::getEmpById((int)$data['c_employee_id']);
        if($employee["rowCount"] == 0)
        {
            $hasError = true;
            $this->msgError(error: "The employee dose not exist");
        }

        // Check 'os' is not assigne to another employee
        $os = EmployeeOSModel::getCurrentOSEmployeeByOSId((int)$data["c_os_id"]);
        if($os["rowCount"] != 0)
        {
            $hasError = true;
            $this->msgError(error: "The os is assigne to another employee");
        }

        if (!$hasError) {
            EmployeeOSModel::assignOS((int) $data["c_os_id"],(int) $data['c_employee_id'], (int)$data['c_role_id'], $data['start_date'], $data['end_date'], $data['is_delegate'], $data["c_job_id"]);
        }

        if($data['assignOsView'] == 1) {
            return $this->response
            ->withHeader('Location', '/employee/assigne_position/'.$data['employee_no'])
            ->withStatus(302);
        } else {
            return $this->response
            ->withHeader('Location', 'view')
            ->withStatus(302);
        }
        
    }
}
