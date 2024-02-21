<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Models\Role\RoleModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;

class DeleteRoleAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = $this->request->getAttribute("id");

        $os = EmployeeOSModel::getCurrentEmployeeOSByRole((int)$id);
        if ($os['status'] == true && $os['rowCount'] == 0) {
            RoleModel::setStatus((int)$id, 0);            
        } else {
            $this->msgError(error: "the role is connected with an os");
        }       

        return $this->response
         ->withHeader('Location', '/roles')
         ->withStatus(302);     
    }
}