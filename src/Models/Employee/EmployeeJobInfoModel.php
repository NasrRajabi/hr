<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Models\Model;


class EmployeeJobInfoModel
{


    public static function storeTran(array $job_info): array
    {

        $sql = 'INSERT INTO public.employee_job_info(employee_id, contract_type, job_title, general_management, department, division, div, class, grade, job_start_date, job_end_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $results = Model::query_set_tran($sql, $job_info);
        return $results;
    }

    public static function getJobInfoById(int $employee_id): array
    {
        $sql = 'SELECT 
                    employee_job_info.* , 
                    jobs.job_title             
                FROM 
                    employee_job_info ,
                    jobs                  
                WHERE
                    employee_job_info.job_title = jobs.id
                AND                    
                    employee_id = ? ';

        $results =Model::query_get_one($sql, [$employee_id]);

        return $results;
    }    
}
