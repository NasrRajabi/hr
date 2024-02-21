<?php

declare(strict_types=1);

namespace App\Models\Employee;


use App\Models\Model;


class EmployeeBasicInfoModel
{


    

    public static function storeTran(array $basic_info): array
    {

        $sql = 'INSERT INTO employee_basic_info( employee_no, f_name, s_name, t_name, l_name, en_name, gender, religion, birthday, birthplace, nationality, national_id, passport_no, marital_status, disability, disability_desc)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )';

        $results = Model::query_set_tran($sql, $basic_info);
        return $results;
    }

    public static function getEmpById(int $employee_id): array
    {
        $sql = 'SELECT 
                    *             
                FROM 
                    employee_basic_info                    
                WHERE                    
                    id = ? ';

        $results =Model::query_get_one($sql, [$employee_id]);

        return $results;
    }


    public static function employeeWAgreement(int $employee_id): array
    {
        $sql = 'SELECT 
                    *             
                FROM 
                    employee_basic_info         
                    left join employee_basic_info on           
                WHERE                    
                    id = ? ';

        $results =Model::query_get_one($sql, [$employee_id]);

        return $results;
    }


}


