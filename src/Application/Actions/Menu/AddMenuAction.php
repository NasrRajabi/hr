<?php
declare(strict_types=1);
namespace App\Application\Actions\Menu;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class AddMenuAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {


        return $this->view->render(
            $this->response,
            'menu/add.twig'
        );
    }

}