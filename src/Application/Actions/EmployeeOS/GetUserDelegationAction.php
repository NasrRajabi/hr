<?php

declare(strict_types=1);

namespace App\Application\Actions\EmployeeOS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Employee\EmployeeModel;
use App\Models\Os\OsModel;

class GetUserDelegationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        //TODO_AYA: check if need to get only employee directly under the user
        $emp = EmployeeModel::getEmployeeBaseInfo((int)$data["employee_no"]);
        if($emp['status'] == true && $emp['rowCount'] > 0) {
            // get employee positions
            // TODO_Aya: get isdelegate value from constant file
            $emp_os_list = EmployeeOSModel::getAllEmployeeOS((int)$emp['result'][0]->id, 1);
            $os = OsModel::all();
            return $this->responseFormatter->asJson($this->response, [$emp['result'][0], $emp_os_list['result'], $os['result']]);
        } else {
            // TODO_AYA: fix the returned error
            return $this->responseFormatter->asJson($this->response->withStatus(400), "الموظف غير موجود");
        }    
    }
}