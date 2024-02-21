<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Models\Model;


class EmployeeOSModel
{
    public static function getAllEmployeeOS(int $emp_id, $is_delegate): array
    {
        // TODO_AYA: check employee on the head of his job
        $sql = 'SELECT employee_os.id, employee_os.start_date, employee_os.end_date, employee_os.os_id, os.name as name, os.parent_id as parent_id, os.dept_type, os.node_level, jobs.job_title from employee_os
                Join os on employee_os.os_id = os.id
                join jobs on employee_os.job_id = jobs.id
                where employee_os.employee_id = ? and is_delegate = ?
                ORDER BY 
                CASE WHEN employee_os.end_date IS NULL THEN 0 ELSE 1 END,
                employee_os.end_date DESC';

        $results = Model::query_get($sql, [$emp_id, $is_delegate]);
        return $results;
    }

    public static function setEndEmployeeOS(int $id, $end_date): array
    {
        $sql = 'UPDATE employee_os SET end_date=? WHERE id=?';
        $results = Model::query_up($sql, [$end_date, $id]);
        return $results;
    }

    public static function getCurrentOSEmployeeByOSId(int $os_id): array
    {
        $sql = 'SELECT * FROM employee_os where os_id = ? and is_delegate = false and (end_date > CURRENT_DATE or end_date is null)';
        $results = Model::query_get($sql, [$os_id]);

        return $results;
    }

    public static function getCurrentDelegatedOSEmployeeByEmpId(int $employee_id): array
    {
        $sql = 'SELECT * FROM employee_os where employee_id = ? and is_delegate = true and (end_date > CURRENT_DATE or end_date is null)';
        $results = Model::query_get($sql, [$employee_id]);

        return $results;
    }

    public static function getCurrentOSEmployeeByEmpId(int $employee_id): array
    {
        $sql = 'SELECT os.name as os_name, os.id as os_id FROM employee_os
            INNER JOIN os on employee_os.os_id = os.id
            where employee_id = ? and (end_date > CURRENT_DATE or end_date is null)';
        $results = Model::query_get($sql, [$employee_id]);

        return $results;
    }

    public static function getCurrentEmployeeOSByRole(int $role_id): array
    {
        $sql = 'SELECT * FROM employee_os WHERE role_id = ? and (end_date > CURRENT_DATE or end_date is null)';
        $results = Model::query_get($sql, [$role_id]);

        return $results;
    }

    public static function assignOS(int $os_id, int $emp_id, int $role_id, $start_date, $end_date, $is_delegate, $job_id): array
    {
        $sql = "INSERT INTO employee_os( os_id, employee_id, role_id, start_date, end_date, is_delegate, job_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

        $results = Model::query_set($sql, [$os_id, $emp_id, $role_id, $start_date, $end_date == '' ? null : $end_date, $is_delegate, $job_id]);

        return $results;
    }

    public static function getAllEmptyOS()
    {
        $sql = 'SELECT *  FROM os
        WHERE NOT EXISTS
        (SELECT *  
           FROM  employee_os
           WHERE os.id = employee_os.os_id and (employee_os.end_date is null or employee_os.end_date >= CURRENT_DATE));';

        $results = Model::query_get($sql);

        return $results;
    }

    public static function getAllEmployeesUnderBox(int $os_id)
    {
        $sql = 'with recursive
        descendants as
          ( select parent_id, id as descendant, name
            from os
          union all
            select d.parent_id, s.id, s.name
            from descendants as d
              join os s
                on d.descendant = s.parent_id
          ) 
        select descendants.descendant as os_id, descendants.name as os_name
            , employee_basic_info.id as emp_id, employee_basic_info.employee_no as employee_no
            , employee_basic_info.f_name, employee_basic_info.s_name, employee_basic_info.t_name, employee_basic_info.l_name
            , employee_os.start_date, employee_os.end_date, employee_os.is_delegate
        from descendants 
        join employee_os on employee_os.os_id = descendants.descendant
        join employee_basic_info on employee_os.employee_id = employee_basic_info.id
        where (parent_id = ? or descendant = ?) and (employee_os.end_date is null or employee_os.end_date >= CURRENT_DATE);
        ';
        $results = Model::query_get($sql, [$os_id, $os_id]);

        return $results;
    }

    public static function getGeneralAdministrationforEmployee($os_id): array
    {
        $sql = "WITH RECURSIVE nodes_cte(id, name, parent_id, dept_type, depth, path) AS (
            SELECT tn.id, tn.name, tn.parent_id, tn.dept_type, 1::INT AS depth, tn.id::TEXT AS path 
            FROM os AS tn 
            WHERE tn.parent_id = 0
           UNION ALL 
            SELECT c.id, c.name, c.parent_id, c.dept_type, p.depth + 1 AS depth , 
                   (p.path || ',' || c.id::TEXT) 
            FROM nodes_cte AS p, os AS c 
            WHERE c.parent_id = p.id 
           )
           SELECT * FROM nodes_cte AS n WHERE n.id = ?;";
        $results = Model::query_get($sql, [$os_id]);
  


        return $results;
    }
}
