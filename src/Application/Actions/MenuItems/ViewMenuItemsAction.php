<?php
declare(strict_types=1);
namespace App\Application\Actions\MenuItems;

use App\Models\Os\OsModel;
use App\Models\Menu\MenuModel;
use App\Application\Actions\Action;
use App\Models\MenuItems\MenuItemsModel;

use App\Models\permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Menu\Util\ColorGenerator;


class ViewMenuItemsAction extends Action
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
            //TODO: redirect error
            dd("Menu not exist");
        }
        
        // Get menu Items
        $menu_items = MenuItemsModel::getMenuItems($id);
       
        // Get all permissions
        $permissions = PermissionsModel::all();



        return $this->view->render(
            $this->response,
            'menu_items/browse.twig',
            [ 
                'menu' => $menu['result'],
                'permissions' => $permissions['result'],
                'menu_items' => $menu_items['result']
            ]
        );
    }

}