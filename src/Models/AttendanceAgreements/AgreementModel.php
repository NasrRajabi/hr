<?php

namespace App\Models\AttendanceAgreements;

use App\Models\Model;
use Cassandra\Date;

class AgreementModel
{

    public static function  all(): array
    {
        $sql = 'SELECT *
                FROM attendance_agreements';

        $results = Model::query_get($sql);

        return $results;
    }
    public static function  allBy(): array
    {
        $sql = 'SELECT *
                FROM attendance_agreements_details
                JOIN attendance_agreements ON attendance_agreements_details.agreement_id = attendance_agreements.id
                ORDER BY attendance_agreements_details.id ASC';
        $results = Model::query_get($sql);

        return $results;
    }

    public static function  findAll(int $id): array
    {
        $sql = 'SELECT *
        FROM attendance_agreements_details
        JOIN attendance_agreements ON attendance_agreements_details.agreement_id = attendance_agreements.id
        WHERE attendance_agreements.id = ?
        ORDER BY attendance_agreements_details.id
                ';
        $results = Model::query_get($sql, [$id]);

        return $results;
    }

    public static function update(int $id)
    {
    }


    public static function  findAgeement(int $id): array
    {
        $sql = 'SELECT * 
                FROM attendance_agreements
                WHERE id = ?';
        $results = Model::query_get($sql, [$id]);

        return $results;
    }



    public static function storeAgreementTrans(array $agreement_data): array
    {

        $sql = " INSERT INTO attendance_agreements(
                 name, description)
                 VALUES (?, ?) ";

        $results = Model::query_set_tran($sql, $agreement_data);

        return $results;
    }

    public static function storeAgreementDetailsTrans(array $agreement__details_data): array
    {

        $sql = " INSERT INTO attendance_agreements_details(
                 agreement_id, day, att_status, start_time, end_time, check_in_end, allowed_time_check_in, allowed_time_check_out, allowed_p_leave_hours)
                 VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $results = Model::query_set_tran($sql, $agreement__details_data);

        return $results;
    }
    public static function updateAgreementTrans(array $agreement_data): array
    {

        $sql = 'UPDATE attendance_agreements
		            SET  name=?, description=?
		            WHERE id=?  ';

        $results = Model::query_up_tran($sql, $agreement_data);

        return $results;
    }

    public static function updateAgreementDetailsTrans(array $agreement__details_data): array
    {

        $sql = '    UPDATE attendance_agreements_details
                    SET  day=?,
                         att_status=?, 
                         start_time=?, 
                         end_time=?,
                         check_in_end=?, 
                         allowed_time_check_in=?, 
                         allowed_time_check_out=?, 
                         allowed_p_leave_hours=?
                    WHERE agreement_id=?
                    AND day=?';

        $results = Model::query_up_tran($sql, $agreement__details_data);

        return $results;
    }



    public static function  employeeAgreementDetial(int $employee_id,  string $dayName): array
    {
        $sql = 'SELECT attendance_agreements_details.*, 
                    employee_basic_info.id as employee_id
                    FROM attendance_agreements_details
                    JOIN attendance_agreements  ON attendance_agreements_details.agreement_id = attendance_agreements.id
                    JOIN employee_basic_info  ON employee_basic_info.attendance_agreements_id = attendance_agreements.id
                    WHERE employee_basic_info.employee_no = ? AND attendance_agreements_details.day = ?;
                    ';
        $results = Model::query_get_one_tran($sql, [$employee_id, $dayName]);

        return $results;
    }

    public static function  getEmpAttendenceAgreement(int $employee_id, string $dayName): array
    {
        $sql = 'SELECT attendance_agreements_details.*
                    FROM attendance_agreements_details
                    JOIN attendance_agreements  ON attendance_agreements_details.agreement_id = attendance_agreements.id
                    JOIN employee_basic_info  ON employee_basic_info.attendance_agreements_id = attendance_agreements.id
                    WHERE employee_basic_info.id = ? AND attendance_agreements_details.day = ? ';
        $results = Model::query_get_one($sql, [$employee_id, $dayName]);

        return $results;
    }
}
