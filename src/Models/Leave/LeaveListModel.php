<?php

declare(strict_types=1);

namespace App\Models\Leave;


use App\Models\Model;


class LeaveListModel extends Model 
{
    public static function  all(): array
    {
        $sql = 'SELECT 
                    leave.*,
                   
                    employee_basic_info.f_name f_name,
                    employee_basic_info.l_name l_name  ,
                    os.name os_name
                    
                FROM 
                leave 
                left join employee_basic_info on leave.employee_id=employee_basic_info.id
                left join employee_os on leave.employee_id=employee_os.employee_id
                left join os on employee_os.os_id=os.id';

        $results =Model::query_get($sql);
   
        return $results;
    }
    public static function getLeave(int $id): array
    {
        $sql = 'SELECT 
                    leave.*,
                   
                   employee_basic_info.f_name f_name,
                   employee_basic_info.l_name l_name  ,
                   os.name os_name
             
                FROM 
                    leave
                    left join employee_basic_info on leave.employee_id=employee_basic_info.id
                left join employee_os on leave.employee_id=employee_os.employee_id
                left join os on employee_os.os_id=os.id
                WHERE                    
                                   
                    id = ?  ';

        $results =Model::query_get_one($sql, [$id]);

        return $results;
    }
    public static function getLeavebyEmpIdAndMonth(int $id, int $month, int $year): array
    {
        $sql = 'SELECT *
        FROM leave
        WHERE employee_id = ? 
        AND EXTRACT(MONTH FROM leave_date) = ? 
        AND EXTRACT(YEAR FROM leave_date) = ?
          ';

        $results =Model::query_get($sql, [$id , $month , $year]);   

        return $results;
    }
    public static function approveLeave(int $leave_id, int $leave_status): array
    {

        $sql = 'UPDATE
                    leave
                SET
                    leave_status = ?
                WHERE
                    id = ? ';

        $results = Model::query_up($sql, [ $leave_status, $leave_id ] );

        return $results; 
    }  
    public static function getLeaveBydate($leave_date){

            $sql = 'SELECT 
                         leave.*,
                   
                   employee_basic_info.f_name f_name,
                   employee_basic_info.l_name l_name  ,
                   os.name os_name
             
                FROM 
                    leave
                    left join employee_basic_info on leave.employee_id=employee_basic_info.id
                left join employee_os on leave.employee_id=employee_os.employee_id
                left join os on employee_os.os_id=os.id
                        WHERE                    
                                        
                            created_at = ?   ';

            $results =Model::query_get($sql, [$leave_date]);

                    return $results;

    }
    public static function getLeaveBydateType($start_date,$end_date, $leave_type){

        $sql = 'SELECT 
         leave.*,
                   
                   employee_basic_info.f_name f_name,
                   employee_basic_info.l_name l_name  ,
                   os.name os_name
             
                FROM 
                    leave
                    left join employee_basic_info on leave.employee_id=employee_basic_info.id
                left join employee_os on leave.employee_id=employee_os.employee_id
                left join os on employee_os.os_id=os.id
                    WHERE                    
                                    
                        created_at BETWEEN ? AND  ?  and leave_type = ? ';

        $results =Model::query_get($sql, [$start_date,$end_date, $leave_type]);

                return $results;

}
            public static function getLeaveByTowDate($start_date,$end_date){

                $sql = 'SELECT 
                 leave.*,
                   
                   employee_basic_info.f_name f_name,
                   employee_basic_info.l_name l_name  ,
                   os.name os_name
             
                FROM 
                    leave
                    left join employee_basic_info on leave.employee_id=employee_basic_info.id
                left join employee_os on leave.employee_id=employee_os.employee_id
                left join os on employee_os.os_id=os.id
                            WHERE                    
                                            
                                created_at BETWEEN ? AND  ?   ';

                $results =Model::query_get($sql, [$start_date,$end_date]);

                        return $results;

            }
            public static function getLeaveStatusdateType($sts){

                $sql = 'SELECT 
                leave.*,
                   
                   employee_basic_info.f_name f_name,
                   employee_basic_info.l_name l_name  ,
                   os.name os_name
             
                FROM 
                    leave
                    left join employee_basic_info on leave.employee_id=employee_basic_info.id
                left join employee_os on leave.employee_id=employee_os.employee_id
                left join os on employee_os.os_id=os.id
                            WHERE                    
                                            
                                leave_status=?   ';
            
                $results =Model::query_get($sql, [$sts]);
            
                        return $results;
            
            }

            public static function  allempindept(): array
            {
              $id= $_SESSION['os_id'] ;
                $sql = 'SELECT employee_os.employee_id,employee_basic_info.f_name,employee_basic_info.l_name
                         from employee_os
                         left join employee_basic_info on employee_os.employee_id=employee_basic_info.id
                            where employee_os.os_id=? ';
                       
      
                $results =Model::query_get($sql,[$id]);
              
                return $results;
            }
            

}

