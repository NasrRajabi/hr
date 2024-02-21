<?php
declare(strict_types=1);
namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use App\Models\permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;

class ViewPermissionsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $all = PermissionsModel::all();

        return $this->view->render(
            $this->response,
            'permissions/browse.twig',
            [ 'allPermissions' => $all['result'] ]
        );
    }
}