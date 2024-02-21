<?php
declare(strict_types=1);
namespace App\Application\Actions\MenuItems;

use App\Application\Actions\Action;
use App\Models\MenuItems\MenuItemsModel;
use App\Models\Model;
use Psr\Http\Message\ResponseInterface as Response;


class UpdateMenuItemsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();

        $id = (int) $this->args['id'];

        #TODO Asem Yamak => Add validation
        // Get menu
        //$menu = MenuModel::getMenu($id);


        // Get menu Items
        $menu_items = MenuItemsModel::getMenuItems($id);


        Model::start_tran();

        foreach ($menu_items['result'] as $item) {
            MenuItemsModel::updateMenuItemsTrans([
                $body['title_'. $item->item_id],
                $body['parent_id_'. $item->item_id],
                $body['order_no_'. $item->item_id],
                $body['icon_class_'. $item->item_id],
                $body['permission_id_'. $item->item_id],
                $body['color_'. $item->item_id],
                $body['parameters_'. $item->item_id],
                $body['url_'. $item->item_id],
                $item->item_id,
            ]);
        }
        Model::save_tran();

        return $this->response
         ->withHeader('Location', '/menu_items/'.$id)
         ->withStatus(302);        
    }
}