<?php

declare(strict_types=1);
namespace App\Models\Role;

use App\Models\Model;

class RoleModel
{

    public static function  all(): array
    {
        $sql = 'SELECT *  FROM roles where status != 0 ORDER BY id';
        $results =Model::query_get($sql);

        return $results;
    }

    public static function getRole(int $id): array
    {
        $sql = 'SELECT * FROM  roles WHERE id = ? ';
        $results = Model::query_get($sql, [$id]);

        return $results;
    }

    public static function getRolePermissionsIds(int $id): array
    {
        $sql = 'SELECT * FROM  permission_role WHERE role_id = ? ';
        $results =Model::query_get($sql, [$id]);

        return $results;
    }

    public static function getRolePermissions(int $id): array
    {
        $sql = 'SELECT permissions.key, permissions.group_name FROM permissions INNER JOIN permission_role ON permissions.id = permission_role.permission_id WHERE permission_role.role_id = ? ';
        $results =Model::query_get($sql, [$id]);

        return $results;
    }

    public static function getRoleByName(string $name): array
    {
        $sql = 'SELECT * FROM  roles WHERE role_name = ? ';
        $results =Model::query_get($sql, [$name]);

        return $results;
    }
    
    public static function setStatus($id, $status): array
    {
        $sql = 'UPDATE roles SET status=? WHERE id=?';
        $results = Model::query_up_tran($sql, [$status, $id]);

        return $results;
    }

    public static function updateTra($id, $role_name, $description): array
    {
        $sql = 'UPDATE roles SET  role_name=?, description=? WHERE id=?';
        $results = Model::query_up_tran($sql, [$role_name, $description, $id]);

        return $results;
    }

    public static function storeTra($role_name, $description, $status): array
    {
        //TODO_Aya: check status to be read from constant file
        // status: 0: disabled. 1: os role. 2: delegation role
        $sql = 'INSERT INTO roles (role_name, description, status)
        VALUES (?, ?, ?)';
        $results = Model::query_set_tran($sql, [$role_name, $description, $status]);

        return $results;
    }

    public static function storeTranRolePermission(int $role_id, int $permission_id):array
    {
        $sql = 'INSERT INTO permission_role(role_id, permission_id) VALUES ( ?, ?)';

        $results = Model::query_up_tran($sql, [$role_id, $permission_id]);
        return $results;
    }

    public static function deleteRolePermissionsTra(int $role_id):array
    {
        $sql =  'DELETE  FROM permission_role WHERE role_id = ?';

        $results = Model::query_up_tran($sql, [$role_id]);
        return $results;
    }

    public static function deleteTra(int $id):array
    {
        $sql =  'DELETE FROM roles WHERE id = ?';

        $results = Model::query_up_tran($sql, [$id]);
        return $results;
    }
}