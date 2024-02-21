<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Application\Actions\Role\Util\ColorGenerator;
use App\Models\Role\RoleModel;
use Psr\Http\Message\ResponseInterface as Response;

class DetailsRoleAction extends Action
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
        
        // Get role permissions details
        $role_permissions = RoleModel::getRolePermissions((int)$id);

        $cg = new ColorGenerator();

        return $this->view->render(
            $this->response,
            'role/details.twig',
            [ 
                'role' => $role['result'][0],
                'permissions' => $role_permissions['result'],
                'cg' => $cg]
        );
    }
}