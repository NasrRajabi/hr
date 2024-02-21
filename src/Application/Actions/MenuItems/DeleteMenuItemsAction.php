<?php
declare(strict_types=1);
namespace App\Application\Actions\MenuItems;

use App\Models\MenuItems\MenuItemsModel;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteMenuItemsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = $this->request->getAttribute("id");
        $menu_id = $this->request->getAttribute("menu_id");

        # TODO: Asem Yamak before delete menu item, check if the menu item id connect to menu_id (Add validation)

        MenuItemsModel::deleteMenuItem((int) $id);

        return $this->response
         ->withHeader('Location', '/menu_items/'.$menu_id)
         ->withStatus(302);     
    }
}