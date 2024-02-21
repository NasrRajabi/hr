<?php

declare(strict_types=1);
namespace App\Models\Menu;

use App\Models\Model;

class MenuModel
{


    public static function  all(): array
    {
        $sql = 'SELECT *  FROM menus ORDER BY id';
        $results =Model::query_get($sql);

        return $results;
    }

    public static function  store(string $name,string $description): array
    {
        $sql = 'INSERT INTO public.menus(
                    menu_name, description)
                    VALUES (?, ?)';
        return Model::query_set($sql,[$name, $description]);

    }

    public static function getMenu(int $id): array
    {
        $sql = 'SELECT * FROM  menus WHERE id = ? ';
        return Model::query_get_one($sql, [$id]);
    }



    public static function deleteMenuPermissionsTra(int $role_id):array
    {
        $sql =  'DELETE  FROM permission_role WHERE role_id = ?';

        $results = Model::query_up_tran($sql, [$role_id]);
        return $results;
    }

    public static function deleteTra(int $id):array
    {
        $sql =  'DELETE FROM menus WHERE id = ?';

        $results = Model::query_up_tran($sql, [$id]);
        return $results;
    }

    public static function update(int $id, string $menu_name, string $description)
    {
        $sql = 'UPDATE public.menus
                SET menu_name=?, description=?
                WHERE id =?';

        return Model::query_up($sql,[$menu_name, $description, $id]);
    }

    public static function deleteMenu(int $id)
    {
        $sql = 'DELETE FROM public.menus
	                WHERE id = ? ';
        return Model::query_up($sql,[$id]);
    }

    public static function menuMenuItems(array $permissionIds): array
    {
// Assume $permissionIds is the array of permission IDs
        $placeholder = rtrim(str_repeat('?,', count($permissionIds)), ',');
        $sql = "SELECT m.menu_name, mi.*
                    FROM menus m
                    JOIN menu_items mi ON m.id = mi.menu_id
                    WHERE mi.permission_id IN ($placeholder)
                    ORDER BY m.id, mi.order_no
                ";
        return Model::query_get($sql,$permissionIds);

    }
}