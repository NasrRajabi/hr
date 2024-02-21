<?php
declare(strict_types=1);
namespace App\Application\Actions\Menu;


use App\Models\MenuItems\MenuItemsModel;
use App\Application\Actions\Action;
use App\Models\Menu\MenuModel;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteMenuAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int) $this->request->getAttribute("id");

        # TODO: Asem Yamak before delete menu  (Add validation)

        $menuItems = MenuItemsModel::getMenuItems($id);

        if ($menuItems['rowCount'] >= 1){
            $this->msgError(error: 'خطأ في حذف قائمة رئيسية');
        } else {
            $this->msgSuccess(success: 'تم الحذف بنجاح');
            MenuModel::deleteMenu($id);
        }

       return $this->redirect(route: '/menus');

    }


}