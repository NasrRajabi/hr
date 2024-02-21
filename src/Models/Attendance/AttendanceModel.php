<?php

namespace App\Models\Attendance;

use App\Models\Model;
use Cassandra\Date;

class AttendanceModel
{

    public static function  all(): array
    {
        $sql = 'SELECT *  FROM attendance';
        $results =Model::query_get($sql);

        return $results;
    }

 
    public static function store(int $employee_no,string $date , int $state, int $type, int $device_id ) : array {

        $sql = " INSERT INTO attendance(employee_no,date,state,type,device_id) 
                 VALUES
                 (?,?,?,?,? )";
        $results =Model::query_set_tran($sql,[$employee_no,$date,$state,$type,$device_id]);
 
        return $results;
    }   
}

