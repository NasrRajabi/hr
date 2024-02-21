<?php
declare(strict_types=1);
namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use App\Models\Permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;

class EditPermissionsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = $this->request->getAttribute("id");
        $data = PermissionsModel::get((int)$id);
        
        return $this->view->render(
            $this->response,
            'permissions/edit.twig',
            [ 'permission' => empty($data['result']) ? [] :  $data['result'][0] ]
        );
    }
}