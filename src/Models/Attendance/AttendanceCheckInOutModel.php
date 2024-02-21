<?php

namespace App\Models\Attendance;

use App\Models\Model;

class AttendanceCheckInOutModel
{

    public static function  getEmployeeAttendance(int $employee_id, string $date): array
    {
        $sql = 'SELECT *  FROM attendance_check_in_out WHERE employee_id = ? AND date= ?';
        $results = Model::query_get_one_tran($sql, [$employee_id, $date]);

        return $results;
    }


    public static function store(int $employee_id, string $date, ?string $checkIn, ?string $checkOut, int $deviceId): array
    {

        $sql = "INSERT INTO attendance_check_in_out (employee_id, date, check_in, check_out, device_id)
        VALUES (?, ?, ?, ?, ?)
        ON CONFLICT (employee_id, date) DO UPDATE
        SET check_out = ?           
                    ";
        $results = Model::query_set_tran($sql, [$employee_id, $date, $checkIn,$checkOut, $deviceId, $checkOut]);

        return $results;
    }
}
