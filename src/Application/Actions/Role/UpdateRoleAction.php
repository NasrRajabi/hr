<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Models\Model;
use App\Models\Role\RoleModel;
use App\Models\permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Role\RoleRequestValidator;

class UpdateRoleAction extends Action
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
        $data = $this->requestValidatorFactory->make(RoleRequestValidator::class)->validate($body);

        $oldRole = RoleModel::getRole((int)$data['id']);
        $role = RoleModel::getRoleByName($data['role_name']);
        // The update role process will be done if: (1) The edited role is exist. (2) The role name dose not change or dose not reserved for another role.
        // In order to update role's permissions: delete all current role's permissions, then add the submitted ones.
        if ($oldRole['status'] == true && $oldRole['rowCount'] > 0 && (($role['status'] == true && $role['rowCount']  == 0) || $oldRole['result'][0]->role_name == $data['role_name'])) {
            Model::start_tran();
            RoleModel::deleteRolePermissionsTra((int)$data['id']);
            RoleModel::updateTra($data['id'], $data['role_name'], $data['description']);
            foreach ($new_permissions as  $value) {
                RoleModel::storeTranRolePermission((int)$data['id'], (int)$value);
            }
            Model::save_tran();
        } else {
            $this->msgError(error: "Role Name is reserved for another Role");
        }

        return $this->response
         ->withHeader('Location', '/roles')
         ->withStatus(302);        
    }
}