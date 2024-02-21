<?php
declare(strict_types=1);
namespace App\Application\Actions\Menu;

use App\Application\Actions\Action;

use App\Models\Menu\MenuModel;
use Psr\Http\Message\ResponseInterface as Response;

class ViewMenusAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $all = MenuModel::all();

        return $this->view->render(
            $this->response,
            'menu/browse.twig',
            [ 'menus' => $all['result'] ]
        );
    }
}