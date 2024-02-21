<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Application\Actions\Role\Util\ColorGenerator;
use App\Models\Os\OsModel;
use App\Models\Role\RoleModel;
use App\Models\permissions\PermissionsModel;

use Psr\Http\Message\ResponseInterface as Response;

class EditRoleAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Get role 
        $id = $this->request->getAttribute("id");
        $role = RoleModel::getRole((int)$id);

        if(empty($role['result'])) {
            $this->msgError(error: "Role not exist");
            return $this->response
                ->withHeader('Location', '/roles')
                ->withStatus(302);
        }
        
        // Get role permissions
        $role_permissions = RoleModel::getRolePermissionsIds((int)$id);
        
        // Get all permissions
        $permissions = PermissionsModel::all();
        $permissions = $this->_group_by($permissions['result']);

        $cg = new ColorGenerator();

        return $this->view->render(
            $this->response,
            'role/edit.twig',
            [ 
                'role' => $role['result'][0],
                'permissions' => $permissions,
                'role_permissions' => array_column($role_permissions['result'], 'permission_id'),
                'cg' => $cg]
        );
    }

    function _group_by($array) {
        $return = array();
        foreach($array as $val) {
            $return[$val->group_name][] = $val;
        }
        return $return;
    }
}