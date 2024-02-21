<?php
declare(strict_types=1);
namespace App\Models\Permissions;

use App\Models\Model;

class PermissionsModel
{

    public static function  all(): array
    {
        $sql = 'SELECT *  FROM permissions ORDER BY id';
        $results =Model::query_get($sql);

        return $results;
    }

    public static function update($id, $key,  $group_name, $description): array
    {
        $sql = 'UPDATE permissions SET  key=? ,group_name=?, description=? WHERE id=?';
        $results = Model::query_up($sql, [$key,  $group_name, $description, $id]);

        return $results;
    }

    public static function store($key,  $group_name, $description): array
    {
        $sql = 'INSERT INTO permissions (key, group_name, description)
        VALUES (?, ?, ?)';
        $results = Model::query_up($sql, [$key,  $group_name, $description]);

        return $results;
    }


    public static function get(int $id): array
    {
        $sql = 'SELECT 
                    *             
                FROM 
                    permissions                    
                WHERE                    
                    id = ? ';
        $results =Model::query_get($sql, [$id]);

        return $results;
    }

    public static function delete(int $id): array
    {
        $sql =  'DELETE FROM permissions WHERE id = ?';
        $results =Model::query_up($sql, [$id]);

        return $results;
    }

    public static function getPermissionRoles(int $id): array
    {
        $sql = 'SELECT 
                    *             
                FROM 
                    permission_role                    
                WHERE                    
                    permission_id = ? ';
        $results =Model::query_get($sql, [$id]);

        return $results;
    }
}