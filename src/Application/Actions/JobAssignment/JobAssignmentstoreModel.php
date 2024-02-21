<?php

declare(strict_types=1);

namespace App\Models\JobAssignment;


use App\Models\Model;


class JobAssignmentstoreModel
{

//
    public static function store(array $basic_info): array
    {
   
        $sql = 'INSERT INTO job_assigment(mission_type,mission_status,mission_supject,mission_start_date,
        mission_end_date,mission_country,hosted_type,mission_funded,short_description,note,create_user,create_date)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';

        $results = Model::query_set($sql, $basic_info);
        
        return $results;
    }
    public static function store_local_assignment(array $basic_info): array
    {
       
        $sql = 'INSERT INTO job_assigment(employee_id,mission_type,mission_status,mission_supject,mission_start_date,mission_end_date,mission_city,note,create_user,create_date)
                        VALUES (?,?,?,?,?,?,?,?,?,?)';

        $results = Model::query_set($sql, $basic_info);
        
        return $results;
    }
    public static function check(array $basic_info): array
    {
        $sql='select * from job_assigment
        where employee_id= ? and
        mission_start_date=? and 
        (mission_start_date=? or mission_end_date=?) and 
        (  ? between mission_start_date and mission_end_date                    
        OR
         ? between mission_start_date and mission_end_date  ) 
        ';
$results =Model::query_get($sql, [$basic_info['employee_id'],
$basic_info['mission_start_date'],$basic_info['mission_start_date'],$basic_info['mission_end_date'],$basic_info['mission_start_date'],$basic_info['mission_end_date']]);

return $results;
    }  
    
    public static function list(): array
    {
        $sql='select job_assigment.* ,employee_basic_info.f_name,employee_basic_info.l_name
        from job_assigment
        left join employee_basic_info on job_assigment.employee_id=employee_basic_info.id
        where EXTRACT(MONTH FROM mission_start_date)= EXTRACT(MONTH FROM now())       
        ';
$results =Model::query_get($sql);

return $results;
    }   
    public static function search($sts,$startDate,$endtDate): array
    {
        $sql='select job_assigment.* ,employee_basic_info.f_name,employee_basic_info.l_name
        from job_assigment
        left join employee_basic_info on job_assigment.employee_id=employee_basic_info.id
        where mission_type=? 
        AND
        mission_start_date >= ?
    AND
    mission_end_date <= ?
    ORDER BY
    mission_start_date       
        ';
        
$results =Model::query_get($sql,[$sts,$startDate,$endtDate]);

return $results;
    }  
    /*  بعد */
    public static function viow_job_assigment($id): array
    {
        $sql='select * from job_assigment
        where id= ? 
       
        ';
            $results =Model::query_get($sql,[$id]);

            return $results;
    }
   
}
