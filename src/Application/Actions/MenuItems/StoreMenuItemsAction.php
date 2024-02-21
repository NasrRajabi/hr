<?php
declare(strict_types=1);
namespace App\Application\Actions\MenuItems;

use App\Application\Actions\Action;
use App\Models\MenuItems\MenuItemsModel;
use Psr\Http\Message\ResponseInterface as Response;


class StoreMenuItemsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();

        #TODO Asem Yamak add Validation
        $addItem = MenuItemsModel::storeMenuItems(  (int) $data['menu_id'],
                                                    (int) $data['permission_id'],
                                                    $data['title'],
                                                    $data['icon_class'],
                                                    $data['color'],
                                                    (int) $data['parent_id'],
                                                    $data['order_no'],
                                                    $data['parameters'],
                                                    $data['url'],
                                                );

        if($addItem['rowCount'] !== 1) {
            return $this->responseFormatter->asJson($this->response->withStatus(400), "خطأ في ادخال العنوان الجديد");
        }
$data['item_id'] = $addItem['lastInsertId'];
        return $this->responseFormatter->asJson($this->response, $data);
    }
}