<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Models\role\RoleModel;
use Psr\Http\Message\ResponseInterface as Response;

class ViewRolesAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $all = RoleModel::all();

        return $this->view->render(
            $this->response,
            'role/browse.twig',
            [ 'roles' => $all['result'] ]
        );
    }
}