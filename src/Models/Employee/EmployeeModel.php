<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Models\Model;


class EmployeeModel
{


    public static function all_emp_name(): array
    {

        $sql = 'SELECT id, employee_no, f_name, s_name, t_name, l_name
                FROM public.employee_basic_info
                WHERE employee_status =1
                
                ';

        $results = Model::query_get($sql);
        // dd($results);
        return $results;
    }
    
    public static function all(): array
    {

        $sql = 'SELECT 
                basic.*, 
                basic.id AS emp_id, 
                job.contract_type, job.job_title,
                position.os_id, 
                contact.*,
                title.job_title
                FROM employee_basic_info AS basic 
                LEFT JOIN employee_job_info AS job ON basic.id = job.employee_id
                LEFT JOIN employee_os AS position ON basic.id = position.employee_id
                LEFT JOIN jobs AS title ON job.job_title = title.id
                LEFT JOIN employee_contacts_info AS contact ON basic.id = contact.employee_id
                -- LEFT JOIN employee_education_info AS edu ON basic.id = edu.employee_id
                -- LEFT JOIN employee_addresses_info AS address ON basic.id = address.employee_id
                --JOIN employee_os on basic.id = employee_os.employee_id
                --JOIN os on  employee_os.os_id = os.id
                -- order by basic.id desc
                ';

        $results = Model::query_get($sql);
        // dd($results);
        return $results;
    }




    public static function all_with_os_position(): array
    {
        $sql = "WITH RECURSIVE nodes_cte(id, name, parent_id, depth, path) AS (
            SELECT tn.id, tn.name, tn.parent_id, 1::INT AS depth, tn.id::TEXT AS path 
            FROM os AS tn 
            WHERE tn.parent_id = 0
            UNION ALL 
            SELECT c.id, c.name, c.parent_id, p.depth + 1 AS depth, 
                   (p.path || ',' || c.id::TEXT) 
            FROM nodes_cte AS p, os AS c 
            WHERE c.parent_id = p.id
        )
        
        SELECT 
            basic.*, 
            basic.id AS emp_id, 
            job.contract_type, 
            job.job_title,
            position.os_id, 
            contact.*,
            title.job_title,
            n.path,
            (SELECT string_to_array(path, ',') FROM nodes_cte WHERE nodes_cte.path = n.path) AS path_array,
            (
                SELECT array_agg(os.name ORDER BY os.id) 
                FROM os 
                WHERE os.id = ANY(string_to_array(n.path, ',')::int[])
                  AND os.id NOT IN (1, 6, 10,18) -- Exclude nodes 1 and 6 from the aggregation
            ) AS path_item_names
                FROM employee_basic_info AS basic 
                LEFT JOIN employee_job_info AS job ON basic.id = job.employee_id
                LEFT JOIN employee_os AS position ON basic.id = position.employee_id
                LEFT JOIN jobs AS title ON job.job_title = title.id
                LEFT JOIN employee_contacts_info AS contact ON basic.id = contact.employee_id
                LEFT JOIN nodes_cte AS n ON n.id = position.os_id
            
        ";

        $results = Model::query_get($sql);

        return $results;
    }

    

    public static function find(int $id): array
    {

        $sql = 'SELECT *
                    FROM employee_basic_info AS basic 
                    LEFT JOIN employee_job_info AS job ON basic.id = job.employee_id
                    LEFT JOIN employee_contacts_info AS contact ON basic.id = contact.employee_id
                     LEFT JOIN employee_os AS position ON basic.id = position.employee_id
                    -- INNER JOIN employee_education_info AS edu ON basic.id = edu.employee_id
                    -- INNER JOIN employee_addresses_info AS address ON basic.id = address.employee_id
                    WHERE basic.id = ?
                ';

        $results = Model::query_get_one($sql, [$id]);
        return $results;
    }

    public static function getEmployeeBaseInfo(int $emp_no): array
    {
        $sql = 'SELECT *
                FROM employee_basic_info where employee_no = ?';

        $results = Model::query_get($sql, [$emp_no]);
        return $results;
    }
}
