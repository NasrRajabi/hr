<?php

declare(strict_types=1);

namespace App\Application\Actions\OS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Auth\AuthModel;
use App\Models\Employee\EmployeeOSModel;

class GetUserDetailsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $employee = AuthModel::findOneByEmployeeNo($data['employee_no']);
        $os = null;

        if ($employee['rowCount'] > 0) {
            $os = EmployeeOSModel::getCurrentOSEmployeeByEmpId($employee['result']->id);
        }        

        return $this->responseFormatter->asJson($this->response, [$employee, $os]);
    }
}
