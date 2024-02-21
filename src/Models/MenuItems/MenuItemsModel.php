<?php

declare(strict_types=1);
namespace App\Models\MenuItems;

use App\Models\Model;

class MenuItemsModel
{

    public static function getMenuItems(int $id): array
    {
        $sql = 'SELECT menu_items.id item_id, menu_items.menu_id, menu_items.permission_id, menu_items.title, menu_items.icon_class, menu_items.color, menu_items.parent_id, menu_items.order_no, menu_items.parameters, menu_items.url, permissions.id per_id , permissions.key FROM  menu_items 
               INNER JOIN permissions on menu_items.permission_id = permissions.id 
               WHERE menu_items.menu_id = ?
               ORDER BY menu_items.order_no ASC';
        return Model::query_get($sql, [$id]);
    }

    public static function updateMenuItemsTrans(array $array): array
    {
        $sql = 'UPDATE public.menu_items
                SET  title=?, parent_id=?, order_no=?, icon_class=?, permission_id=?, color=?,  parameters=?, url=?
                WHERE id=?';
        return Model::query_up_tran($sql, $array);
    }


    public static function storeMenuItems($menu_id, $permission_id, $title, $icon_class, $color, $parent_id, $order_no, $parameters, $url):array
    {
        $sql = 'INSERT INTO public.menu_items(
                         menu_id, permission_id, title, icon_class, color, parent_id, order_no, parameters, url)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        return Model::query_set($sql, [$menu_id, $permission_id, $title, $icon_class, $color, $parent_id, $order_no, $parameters, $url]);
    }

    public static function deleteMenuItem(int $id): array
    {
        $sql = 'DELETE FROM public.menu_items
	                WHERE id = ? ';
        return Model::query_up($sql,[$id]);
    }

}