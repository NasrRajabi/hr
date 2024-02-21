<?php

declare(strict_types=1);

namespace App\Application\Actions\EmployeeOS;


use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Permissions\PermissionsModel;
use App\Models\Employee\EmployeeOSModel;
use App\RequestValidators\EmployeeOS\EmployeeDelegateRequestValidator;
use App\Models\Model;
use App\Models\Role\RoleModel;


class DelegateActionPost extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $hasError = false;
        $body = $this->requestValidatorFactory->make(EmployeeDelegateRequestValidator::class)->validate($this->request->getParsedBody());

        // check if the employee is already delegated
        $os_emp = EmployeeOSModel::getCurrentDelegatedOSEmployeeByEmpId((int)$body['c_employee_id']);
        if($os_emp["rowCount"] != 0)
         {
            $hasError = true;
            $this->msgError(error: "The employee is already delegated");
         }

        // get user os_id
        $os_id = (int)$this->session->get("os_id");        
        
        // Extract submitted permissions ids from request body (key: permission_(id))
        $permissions = PermissionsModel::all();
        $new_permissions = [];
        foreach ($permissions['result'] as $permission) {
            $x = $permission->id;
            if (array_key_exists('permission_' . $x, $body)) {
                if ($body['permission_' . $x] == $x) {
                    array_push($new_permissions, $body['permission_' . $x]);
                }
            }
        }

        if (empty($new_permissions)) {
            $hasError = true;
            $this->msgError(error:"please choose at least one permission");
        } 
        if(!$hasError) {
            // Create new role: user_delegate_startdate_os: ex (_26723تفويض _عاصم_التطوير التطوير التقني) 
            // Add the new role and its permissions
            // Assigne the permissions to the new role
            Model::start_tran();
            $new_role = RoleModel::storeTra("d_".$body['c_employee_id']."_".$os_id.'_'.str_replace('-', '_', $body['start_date']), '', 2);
            foreach ($new_permissions as $value) {
                RoleModel::storeTranRolePermission($new_role['lastInsertId'], (int)$value);
            }     
            
            Model::save_tran();  
        
            EmployeeOSModel::assignOS($os_id, (int) $body['c_employee_id'], (int)$new_role['lastInsertId'], $body['start_date'], $body['end_date'], $body['is_delegate'], $this->session->get("job_id"));
        }
        
        return $this->response
            ->withHeader('Location', '/delegate/?no='.$body['employee_no'])
            ->withStatus(302);        
    }
}