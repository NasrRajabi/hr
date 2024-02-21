<?php

declare(strict_types=1);

namespace App\Models\Leave;


use App\Models\Model;


class LeaveAddModel
{


    public static function store(array $basic_info): array
    {

        $sql = 'INSERT INTO leave(employee_id,leave_type, leave_dir,need_car, leave_date, leave_start, leave_end,leave_status,created_by,created_at)
                        VALUES (?,?,?,?,?,?,?,?,?,?)';

        $results = Model::query_set($sql, $basic_info);
        return $results;
    }
    public static function check(array $basic_info): array
    {
        $sql='select * from leave
        where employee_id= ? and
        leave_date=? and 
        (leave_start=? or leave_end=?) and 
        (  ? between leave_start and leave_end                    
        OR
         ? between leave_start and leave_end  )  and 
        
        leave_status = 0
        ';
$results =Model::query_get($sql, [$basic_info['employee_id'],
$basic_info['leave_date'],$basic_info['leave_start'],$basic_info['leave_end'],$basic_info['leave_start'],$basic_info['leave_end']]);

return $results;
    }   
}
