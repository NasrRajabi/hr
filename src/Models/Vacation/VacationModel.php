<?php

namespace App\Models\Vacation;

use App\Models\Model;

class VacationModel
{

    public static function  all(): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    emp_vac_balance ';

        $results =Model::query_get($sql);

        return $results;
    }

    public static function getEmpbalance(int $employee_id): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    emp_vac_balance 
                WHERE
                    employee_id = ? ';

        $results =Model::query_get($sql, [$employee_id]);

        return $results;
    }

    public static function getAllEmpBal(int $employee_id): array
    {
        $sql = "SELECT 
                    emp_vac_balance.*  
                  , vacation_type.vacation_name
                FROM 
                    emp_vac_balance 
                  , vacation_type
                WHERE
                    emp_vac_balance.vacation_type = vacation_type.id
                AND                
                    employee_id = ? ";

        $results =Model::query_get($sql, [$employee_id]);

        return $results;
    }

    public static function getEmpbalanceByVacType(int $vac_type, int $employee_id): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    emp_vac_balance 
                WHERE
                    vacation_type = ?
                AND
                    employee_id = ? ';

        $results =Model::query_get_one($sql, [$vac_type, $employee_id]);

        return $results;
    }


    public static function storeEmpVac(array $vac_info): array
    {

        $sql = 'INSERT INTO emp_vacation( employee_id, vacation_type, annual_vac_type, start_date, end_date, address, mobile, phone, notes
                            ,vacation_status, create_user, create_date )
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $results = Model::query_set($sql, $vac_info);

        return $results;
    }

    public static function updateEmpVacation(array $vac_info): array
    {
        $sql = 'UPDATE
                    emp_vacation
                SET
                    vacation_type =  ?,
                    annual_vac_type = ?,
                    start_date = ?,
                    end_date = ?,
                    address = ?,
                    mobile = ?,
                    phone = ?,
                    notes = ?
                WHERE
                    employee_id = ?
                AND
                    vacation_type = ? 
                AND
                    id = ? 
                AND
                    vacation_status != 2 ';

        $results = Model::query_up($sql, $vac_info);

        return $results; 
    }    


    public static function updateEmpVacCurrentBal(int $day_count, int $employee_id, int $vacation_type): array
    {

        $sql = 'UPDATE
                    emp_vac_balance
                SET
                    current_balance = current_balance - ?
                WHERE
                    employee_id = ?
                AND
                    vacation_type = ? ';

        $results = Model::query_up($sql, [$day_count, $employee_id, $vacation_type ] );

        return $results; 
    }    


    public static function returnEmpVacCurrentBal(int $day_count, int $employee_id, int $vacation_type): array
    {

        $sql = 'UPDATE
                    emp_vac_balance
                SET
                    current_balance = current_balance + ?
                WHERE
                    employee_id = ?
                AND
                    vacation_type = ? ';

        $results = Model::query_up($sql, [$day_count, $employee_id, $vacation_type ] );

        return $results; 
    }    

    
    public static function getEmpDuplicateVac(int $employee_id, $start_date, $end_date): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    emp_vacation 
                WHERE                    
                    employee_id = ? 
                AND
                  (  ? between start_date and end_date                    
                OR
                    ? between start_date and end_date ) 
                AND
                    vacation_status in (1 , 2) ';

        $results =Model::query_get($sql, [$employee_id, $start_date, $end_date]);

        return $results;
    }

    public static function getEditEmpDuplicateVac(int $employee_id, $start_date, $end_date, int $id): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    emp_vacation 
                WHERE                    
                    employee_id = ? 
                AND
                  (  ? between start_date and end_date                    
                OR
                    ? between start_date and end_date ) 
                AND
                    id != ? 
                AND
                    vacation_status in (1 , 2) ';

        $results =Model::query_get($sql, [$employee_id, $start_date, $end_date, $id]);

        return $results;
    }


    public static function getAllEmpVaction(int $employee_id): array
    {
        $sql = "SELECT 
                    emp_vacation.*  ,
                    CONCAT(employee_basic_info.f_name,' ',employee_basic_info.l_name) AS create_user_name
                  , vacation_type.vacation_name
                  , emp_vac_balance.start_balance
                  , emp_vac_balance.current_balance

                  , CASE emp_vacation.vacation_type
                        WHEN 1 THEN ' - ' 
                    END separator

                FROM 
                    emp_vacation ,
                    emp_vac_balance ,
                    vacation_type ,
                    employee_basic_info 
                WHERE
                    emp_vacation.vacation_type = vacation_type.id 
                AND
                    emp_vacation.vacation_type = emp_vac_balance.vacation_type 
                AND
                    emp_vacation.employee_id = emp_vac_balance.employee_id                     
                AND
                    emp_vacation.create_user = employee_basic_info.id                                      
                AND                    
                    emp_vacation.employee_id = ? 
                ORDER BY
                    start_date DESC";

        $results =Model::query_get($sql, [$employee_id]);

        return $results;
    }

    
    public static function getAllEmpVactionByMonthByYear(int $employee_id, int $month, int $year): array
    {
        $sql = "SELECT 
                    emp_vacation.*  ,
                    employee_basic_info.en_name AS en_name
                  , vacation_type.vacation_name

                  , CASE emp_vacation.vacation_type
                        WHEN 1 THEN ' - ' 
                    END separator

                FROM 
                    emp_vacation ,
                    vacation_type ,
                    employee_basic_info 
                WHERE
                    emp_vacation.vacation_type = vacation_type.id  
                AND
                    emp_vacation.create_user = employee_basic_info.id                                      
                AND                    
                    employee_id = ? 
                AND 
                EXTRACT(MONTH FROM emp_vacation.start_date ) = ?
                AND 
                EXTRACT(YEAR FROM emp_vacation.start_date) = ?

                ORDER BY
                    start_date DESC";

        $results =Model::query_get($sql, [$employee_id, $month, $year]);

        return $results;
    }


  /*  public static function getManTOEmpVaction(int $employee_id): array
    {
        $sql = "SELECT 
                    emp_vacation.*
                  , vacation_type.vacation_name
                  , CASE emp_vacation.vacation_type
                        WHEN 1 THEN ' - ' 
                    END separator
                FROM 
                    emp_vacation,
                    vacation_type
                WHERE                    
                    emp_vacation.employee_id = ? 
                AND
                    emp_vacation.vacation_type = vacation_type.id
                ORDER BY
                    start_date DESC";

        $results =Model::query_get($sql, [$employee_id]);

        return $results;
    }
*/
    

    public static function getEmpVactionByVacId(int $id, int $employee_id): array
    {
        $sql = 'SELECT 
                    emp_vacation.* ,
                    vacation_type.vacation_name, 
                    current_balance,
                    start_balance,
                    (start_balance - current_balance) AS spent_balance                   
                FROM 
                    emp_vacation,
                    emp_vac_balance,
                    vacation_type
                WHERE        
                    emp_vacation.vacation_type = vacation_type.id             
                AND
                    emp_vacation.vacation_type = emp_vac_balance.vacation_type
                AND
                    emp_vacation.employee_id = emp_vac_balance.employee_id
                AND                    
                    emp_vacation.id = ?                    
                AND
                    emp_vacation.employee_id = ? ';

        $results =Model::query_get_one($sql, [$id, $employee_id]);

        return $results;
    }

    public static function approveEmpVacation(int $vacation_status, int $employee_id, $approve_date, int $vacation_id): array
    {

        $sql = 'UPDATE
                    emp_vacation
                SET
                    vacation_status = ? ,
                    approve_user = ? ,
                    approve_date = ?
                WHERE
                    id = ? ';

        $results = Model::query_up($sql, [ $vacation_status, $employee_id, $approve_date, $vacation_id ] );

        return $results; 
    }  

    public static function getVaction(int $id): array
    {
        $sql = 'SELECT 
                    emp_vacation.* ,
                    vacation_type.vacation_name,
                    current_balance,
                    start_balance,
                    (start_balance - current_balance) AS spent_balance                   
                FROM 
                    emp_vacation,
                    emp_vac_balance,
                    vacation_type
                WHERE          
                    emp_vacation.vacation_type = vacation_type.id
                AND
                    emp_vacation.vacation_type = emp_vac_balance.vacation_type
                AND
                    emp_vacation.employee_id = emp_vac_balance.employee_id                    
                AND                    
                    emp_vacation.id = ?  ';

        $results =Model::query_get_one($sql, [$id]);

        return $results;
    }

    public static function getEmpVactionSearch( int $emp_id, int $sts, $startDate, $endtDate): array
    {
        
        $sql = 'SELECT 
                    emp_vacation.*  ,
                    employee_basic_info.en_name
                FROM 
                    emp_vacation ,
                    employee_basic_info 
                WHERE                    
                    emp_vacation.employee_id = employee_basic_info.id                
                AND
                    emp_vacation.employee_id = ? 
                AND
                    vacation_status = ?
                AND
                    start_date >= ?
                AND
                    end_date <= ?
                ORDER BY
                    start_date ';

        $results =Model::query_get($sql, [$emp_id, $sts, $startDate, $endtDate]);

        return $results;
    }

    public static function getEmpVactionSearchAllSTS( int $emp_id, int $sts, $startDate, $endtDate): array
    {
        
        $sql = 'SELECT 
                    emp_vacation.*  ,
                    employee_basic_info.en_name
                FROM 
                    emp_vacation ,
                    employee_basic_info 
                WHERE                    
                    emp_vacation.employee_id = employee_basic_info.id                
                AND
                    emp_vacation.employee_id = ? 
                AND
                    start_date >= ?
                AND
                    end_date <= ?
                ORDER BY
                    start_date ';

        $results =Model::query_get($sql, [$emp_id, $startDate, $endtDate]);

        return $results;
    }

    
}

