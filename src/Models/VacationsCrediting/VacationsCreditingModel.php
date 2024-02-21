<?php

namespace App\Models\VacationsCrediting;

use App\Models\Model;

class VacationsCreditingModel
{

    public static function  all(): array
    {
        $sql = 'SELECT employee_basic_info.id employee_id,
                        employee_basic_info.employee_no,
                        employee_basic_info.f_name,
                        employee_basic_info.s_name,
                        employee_basic_info.t_name,
                        employee_basic_info.l_name,
                        employee_basic_info.en_name,
                        employee_basic_info.gender,
                        employee_basic_info.religion,
                        employee_basic_info.marital_status,
                        EXTRACT(year FROM age(current_date,employee_basic_info.birthday)) age,
                        employee_basic_info.attendance_agreements_id,
                        employee_job_info.contract_type,
                        vacation_setting.vac_days,
                        vacation_setting.id va_id,
                        EXTRACT(year FROM age(current_date,employee_job_info.job_start_date))  service_years,
                        vacation_type.id,
                        vacation_setting.vacation_type
     
                from employee_basic_info
                left join employee_job_info on employee_basic_info.id = employee_job_info.employee_id 
                left join vacation_setting on employee_job_info.contract_type = vacation_setting.contract_type
                left join vacation_type on vacation_setting.vacation_type= vacation_type.id
           where (EXTRACT(year FROM age(current_date,employee_basic_info.birthday)) between from_age and to_age)
           and (EXTRACT(year FROM age(current_date,employee_job_info.job_start_date)) between from_service_years and to_service_years)
           and EXTRACT(year FROM age(current_date,employee_basic_info.birthday))<= vacation_type.to_year
           and employee_basic_info.active=true
           and  employee_basic_info.employee_status in (1,2,11)
           --and employee_basic_info.id=112
           ';
 
         $results =Model::query_get($sql);

         return $results;

    }
    public static function  emp_vac_balance(int $employee_id ,int $vacation_type ): array
    {
      $sql = 'SELECT * 
      FROM public.emp_vac_balance
      where employee_id=?
      and vacation_type=? 
           ';
 
         $results =Model::query_get($sql,[$employee_id,$vacation_type]);

         return $results;

    }
    public static function  insert_emp_vac_balance(int $employee_id ,int $vacation_type,$start_balance,$current_balance ): array
    {
        //dd($employee_id);
        $sql = 'INSERT INTO emp_vac_balance( employee_id, vacation_type, start_balance, current_balance)
        VALUES (?, ?, ?, ?)';
    
    $results =Model::query_set($sql,[$employee_id, $vacation_type,$start_balance,$current_balance]);

         return $results;
        }

        public static function  update_emp_vac_balance(int $employee_id ,int $vacation_type,$current_balance ): array
        {

          
            $sql = 'UPDATE emp_vac_balance
            SET  current_balance = current_balance + ? 
            where employee_id=? and  vacation_type=? ';
        
        $results =Model::query_up($sql,[$current_balance,$employee_id, $vacation_type]);
    
             return $results;
            }
            public static function  delete_emp_vac_balance(int $employee_id ,int $vacation_type ): array
        {

          
            $sql = 'DELETE FROM emp_vac_balance
                where employee_id=? and  vacation_type=? ';
        
        $results =Model::query_up($sql,[$employee_id, $vacation_type]);
    
             return $results;
            }
            public static function  insert_crediting($user_id): array
            {
                $year=(date("Y"));
                $da=date("Y-m-d");
                $sql = 'INSERT INTO crediting(
                    year_credi, create_user, create_date)
                VALUES (?,?, ?)';
            
            $results =Model::query_set($sql,[$year,$user_id,$da]);
        
                 return $results;
                }
                public static function  check_crediting(): array
                {
                    $year=(date("Y"));
                    
                    $sql = 'SELECT  *
                    FROM crediting
                    where year_credi=?';
                 $results =Model::query_get($sql,[$year]);

                 return $results;
             
                    }

}

