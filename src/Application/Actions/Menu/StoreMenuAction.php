<?php
declare(strict_types=1);
namespace App\Application\Actions\Menu;

use App\Application\Actions\Action;
use App\Exception\ValidationException;
use App\Models\Menu\MenuModel;
use Psr\Http\Message\ResponseInterface as Response;


class StoreMenuAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        #TODO Asem Yamak add Validation
        $menu = MenuModel::store( $data['menu_name'], $data['description']);

        if($menu['rowCount'] !== 1) {
            throw new ValidationException(['description' => ['خطأ في ادخال قائمة رئيسية جديدة']]);
        }
        return $this->response
            ->withHeader('Location', '/menus')
            ->withStatus(302);
    }



}