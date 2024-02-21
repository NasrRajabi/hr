<?php

declare(strict_types=1);

namespace App\Models\Duration;


use App\Models\Model;


class DurationListModel
{


    public static function all(): array
    {
        $dat = date("Y-m-d");

        $sql = 'SELECT employee_basic_info.*,
        attendance_check_in_out.date,
        attendance_check_in_out.check_in,
        attendance_check_in_out.check_out,
        attendance_check_in_out.device_id,
        employee_job_info.job_title,
        employee_os.os_id,
        os.name os_name
        
        FROM employee_basic_info
        left join attendance_check_in_out on 
        (employee_basic_info.id= attendance_check_in_out.employee_id
        AND attendance_check_in_out.date in(select date from attendance_check_in_out where date=?)) 
        left join  employee_os on employee_basic_info.id = employee_os.employee_id
        LEFT JOIN employee_job_info  ON employee_basic_info.id = employee_job_info.employee_id
        left join  os on  employee_os.os_id=os.id  
        WHERE employee_basic_info.employee_status =1              
        ORDER BY attendance_check_in_out.check_in 
        ';

        $results = Model::query_get($sql, [$dat]);
        //dd($results);
        return $results;
    }

    public static function all_with_os(): array
    {

        $dat = date("Y-m-d");
        $sql = "WITH RECURSIVE nodes_cte(id, name, parent_id, dept_type, depth, path) AS (
            SELECT tn.id, tn.name, tn.parent_id,tn.dept_type, 1::INT AS depth, tn.id::TEXT AS path 
            FROM os AS tn 
            WHERE tn.parent_id = 0
            UNION ALL 
            SELECT c.id, c.name, c.parent_id, c.dept_type, p.depth + 1 AS depth, 
                   (p.path || ',' || c.id::TEXT) 
            FROM nodes_cte AS p, os AS c 
            WHERE c.parent_id = p.id
        )
        
        SELECT 
        employee_basic_info.*,
        attendance_check_in_out.date,
        attendance_check_in_out.check_in,
        attendance_check_in_out.check_out,
        attendance_check_in_out.device_id,
        employee_job_info.job_title,
        employee_os.os_id,
        os.name os_name,
        n.path,

            (SELECT string_to_array(path, ',') FROM nodes_cte WHERE nodes_cte.path = n.path) AS path_array,
            (
                SELECT array_agg(os.name ORDER BY os.id) 
                FROM os 
                WHERE os.id = ANY(string_to_array(n.path, ',')::int[]) AND os.dept_type IN (4,5) -- Exclude nodes 1 and 6 from the aggregation
            ) AS public_administration
            FROM employee_basic_info
        left join attendance_check_in_out on 
        (employee_basic_info.id= attendance_check_in_out.employee_id
        AND attendance_check_in_out.date in(select date from attendance_check_in_out where date=?)) 
        left join  employee_os on employee_basic_info.id = employee_os.employee_id
        LEFT JOIN employee_job_info  ON employee_basic_info.id = employee_job_info.employee_id
        left join  os on  employee_os.os_id=os.id  
        LEFT JOIN nodes_cte AS n ON n.id =  employee_os.os_id
        WHERE employee_basic_info.employee_status =1              
        ORDER BY attendance_check_in_out.check_in 
            
        ";

        $results = Model::query_get($sql, [$dat]);

        return $results;
    }
    public static function emp_vacation($data): array
    {
        $dat = date("Y-m-d");
        $sql = 'SELECT
                    emp_vacation.*  
                            
                            FROM 
                                emp_vacation 
                              
                            WHERE                    
                             
                                vacation_status = ?
                            AND ( start_date >= ? or end_date <= ? or ? between start_date and end_date )
                           
            ';
        $results = Model::query_get($sql, [$data['vacation_status'], $dat, $dat, $dat]);

        return $results;
    } //find
    public static function find($id): array
    {
        $dat = date("m");

        $sql = 'SELECT
                 attendance_check_in_out.*  ,
                 employee_basic_info.employee_no, 
                 employee_basic_info.attendance_agreements_id
              
                         
                         FROM 
                         attendance_check_in_out 
                        
        left join employee_basic_info on  attendance_check_in_out.employee_id=employee_basic_info.id
                         WHERE                    
                          
                         employee_id = ?
                         AND EXTRACT(MONTH FROM attendance_check_in_out.date) = ?
                         order by attendance_check_in_out.date
                         
         ';
        $results = Model::query_get($sql, [$id, $dat]);

        return $results;
    }

    public static function findByEmpIdByMonthByYear(int $id, int $month, int $year): array
    {
     

        $sql = 'SELECT
                 attendance_check_in_out.*  ,
                 employee_basic_info.employee_no, 
                 employee_basic_info.attendance_agreements_id
              
                         
                         FROM 
                         attendance_check_in_out 
                        
        left join employee_basic_info on  attendance_check_in_out.employee_id=employee_basic_info.id
                         WHERE                    
                          
                         employee_id = ?
                         AND EXTRACT(MONTH FROM attendance_check_in_out.date) = ?
                         AND EXTRACT(YEAR FROM attendance_check_in_out.date) = ?
                         order by attendance_check_in_out.date
                         
         ';
        $results = Model::query_get($sql, [$id, $month, $year]);

        return $results;
    }
    

    public static function is_exsist($id): array
    {
        $sql = 'SELECT *
                    FROM 
                         attendance_check_in_out 
                         where 
                         employee_id = ?

        ';
        $results = Model::query_get($sql, [$id]);

        return $results;
    }
}
