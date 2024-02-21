<?php
declare(strict_types=1);
namespace App\Application\Actions\Permissions;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddPermissionsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view->render(
            $this->response,
            'permissions/add.twig'
        );
    }
}