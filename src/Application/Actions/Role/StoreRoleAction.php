<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Models\Model;
use App\Models\Role\RoleModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Role\RoleRequestValidator;
use App\Models\permissions\PermissionsModel;

class StoreRoleAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();
        
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
            $this->msgError(error: "please choose at least one permission");
        } 
        
        // Validate the submitted role
        $body["id"] = 0;
        $data = $this->requestValidatorFactory->make(RoleRequestValidator::class)->validate($body);

        // Check role not exist
        $role = RoleModel::getRoleByName($data['role_name']);
        
        if ($role['status'] == true && $role['rowCount'] == 0) {
            //Add the new role and its permissions
            Model::start_tran();
            $new_role = RoleModel::storeTra($data['role_name'], $data['description'], 1);
            foreach ($new_permissions as  $value) {
                RoleModel::storeTranRolePermission($new_role['lastInsertId'], (int)$value);
            }
            
            Model::save_tran();
        } else {
            $this->msgError(error: "This Role already exists, Make sure the Role Name is unique");
        }
        
        return $this->response
         ->withHeader('Location', '/roles')
         ->withStatus(302);     
    }
}