<?php
declare(strict_types=1);

namespace App\Models\Auth;


use App\Models\Model;


class AuthModel
{
    
    public static function find($employee_id): array
    {
        $sql = 'SELECT * FROM public.employee_basic_info where  id = ?';
        $results = Model::query_get_one($sql, [$employee_id]);

        return $results;
    }

    public static function findOneByEmployeeNo($employee_no): array
    {
        // TODO: check if employee is still on top of his work
        $sql = 'SELECT * FROM public.employee_basic_info where  employee_no = ?';
        $results = Model::query_get_one($sql, [$employee_no]);

        return $results;
    }

    // ****************** For Autherizations process ******************
    public static function getOs($employee_id): array
    {
        $sql = 'SELECT * FROM employee_os where employee_id = ? and (end_date > CURRENT_DATE or end_date is null)';
        $results = Model::query_get_one($sql, [$employee_id]);

        return $results;
    }

    public static function getPermissions($role_id): array
    {
        $sql = 'SELECT  permissions.id, permissions.key as "permissions_key"
            FROM permission_role 
            INNER JOIN permissions on permission_role.permission_id = permissions.id
            WHERE permission_role.role_id = ?';
        return Model::query_get_one($sql, [$role_id]);
    }

    public static function updateFirstLogin($employee_id, $newPassword): array
    {
        $sql = 'UPDATE public.employee_basic_info
        SET password = ? , is_first_login = false
        WHERE id = ? ';
        return Model::query_up($sql, [$newPassword, $employee_id]);
    }
    
}
