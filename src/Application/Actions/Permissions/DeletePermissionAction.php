<?php
declare(strict_types=1);
namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use App\Models\permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;

class DeletePermissionAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = $this->request->getAttribute("id");

        // check Permission not used
        $roles = PermissionsModel::getPermissionRoles((int)$id);
        if ($roles['status'] == true && $roles['rowCount']  == 0) {
            PermissionsModel::delete((int)$id);
        } else {
            $this->msgError(error: "The delete did not complete. The Permission already in use by some roles.");
        }

        return $this->response
         ->withHeader('Location', '/permissions')
         ->withStatus(302);     
    }
}