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
        mission_end_date,last_date,mission_country,hosted_type,mission_funded,short_description,note,create_user,create_date)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';

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
    public static function check_out(array $basic_info): array
    {
        $sql='select * from job_assigment
        where mission_start_date=? and 
        (mission_start_date=? or mission_end_date=?) and 
        (  ? between mission_start_date and mission_end_date                    
        OR
         ? between mission_start_date and mission_end_date  ) 
        ';
$results =Model::query_get($sql, [$basic_info['mission_start_date'],$basic_info['mission_start_date'],
                                  $basic_info['mission_end_date'],$basic_info['mission_start_date'],$basic_info['mission_end_date']]);

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
        $sql='select * ,employee_basic_info.f_name,employee_basic_info.l_name
        from job_assigment
        left join employee_basic_info on job_assigment.employee_id=employee_basic_info.id
        where job_assigment.id= ? 
       
        ';
            $results =Model::query_get($sql,[$id]);

            return $results;
    }
    public static function updateJobAssigment(array $array): array
    {
        $sql = 'UPDATE job_assigment
                SET employee_id=? mission_type=? mission_supject=? mission_country=? mission_city=? hosted_type=? 
                    mission_start_date=? mission_end_date=? mission_funded=? mission_status=? short_description=?
                    note=? 
	FROM public.job_assigment;
                WHERE id=?';
        return Model::query_up_tran($sql, $array);
    }
    public static function updatedecJobAssigment($dec ,$user,$date, $id): array
    {
        
        $sql = 'UPDATE job_assigment
                SET 
                mission_status = ? ,
                approve_user = ?,
                approve_date = ?
	            WHERE id = ?';
              
        return Model::query_up($sql, [$dec,$user,$date,$id]);
    }
    public static function Customize_job_assigment( $id): array
    {
        
        $sql = 'select *
              from job_assigment
                    WHERE id = ?';
              
        $results= Model::query_get($sql, [$id]);
        return $results;
    }
    public static function Customize_dep(): array
    {
        
        $sql = 'select *,id dept_id
              from os
                    WHERE  dept_type=5';
              
        $results= Model::query_get($sql);//$id,$da->dept_id,$emp_coun,$user,$date
        return $results;
    }
    public static function store_job_assigment_dep($job_assigment_id,$dep_id,$emp_coun,$user,$date): array
    {
       
        $sql = 'INSERT INTO job_assigment_dep(
             job_assigment_id, dep_id,emp_coun,create_user,create_date)
            VALUES (?, ?, ?, ?, ?)';

        $results = Model::query_set($sql, [$job_assigment_id,$dep_id,$emp_coun,$user,$date]);     
        return $results;
    }
    /*
    UPDATE your_table
    SET column1 = CASE WHEN new_value1 IS NOT NULL THEN new_value1 ELSE column1 END,
        column2 = CASE WHEN new_value2 IS NOT NULL THEN new_value2 ELSE column2 END,
        column3 = CASE WHEN new_value3 IS NOT NULL THEN new_value3 ELSE column3 END
    WHERE primary_key_column = your_primary_key;
    */
}
