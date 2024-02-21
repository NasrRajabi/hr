<?php

declare(strict_types=1);

namespace App\Application\Actions\EmployeeOS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;
use App\Models\Os\OsModel;

class EditUserDelegationAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();

        // Check if user os is heigher or same as delegated os
        $user_os = $this->session->get("os_id");
        $os_path = OsModel::getOsPath($data["os_id"]);
        $os_path = array_map(function($o) { return  $o->id;}, $os_path['result']);
        if (in_array($user_os, $os_path)) {
            if($data["end_date"] != null && $data["end_date"] >= $data["start_date"]) {
                   EmployeeOSModel::setEndEmployeeOS((int)$data["d_id"], $data["end_date"]);          
                } else {
                    $this->msgError(error: "end date should be grater than start date");
                }
        } else {
            $this->msgError(error: "user dose not have permission to update the delegation");
        }

        return $this->response
         ->withHeader('Location', '/delegate/?no='.$data['employee_no'])
         ->withStatus(302); 
    }
}