<?php
declare(strict_types=1);
namespace App\Application\Actions\Menu;


use App\Models\Menu\MenuModel;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;


class EditMenuAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Get menu
        $id = (int) $this->request->getAttribute("id");
        $menu = MenuModel::getMenu($id);

        if(empty($menu['result'])) {
            //TODO: Asem Yamak redirect error
           dd("Menu not exist");
        }
        return $this->view->render(
            $this->response,
            'menu/edit.twig',
            [ 'menu' => $menu['result'] ]
        );
    }
}