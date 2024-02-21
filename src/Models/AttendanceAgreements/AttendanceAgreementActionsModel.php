<?php

namespace App\Models\AttendanceAgreements;

use App\Models\Model;
use Cassandra\Date;

class AttendanceAgreementActionsModel
{

    public static function  employeeAgreementDetial(int $employee_no, string $dayName): array
    {
        $sql = 'SELECT attendance_agreements_details.*,
                    employee_basic_info.id as employee_id

                    FROM attendance_agreements_details attendance_agreements_details
                    JOIN attendance_agreements ON attendance_agreements_details.agreement_id = attendance_agreements.id
                    JOIN employee_basic_info ON employee_basic_info.attendance_agreements_id = attendance_agreements.id
                    WHERE employee_basic_info.employee_no = ?
                    AND attendance_agreements_details.day = ?
                    AND attendance_agreements_details.agreement_id = (
                        SELECT agreement_id
                        FROM attendance_agreement_employee_actions
                        WHERE employee_no = ?
                        ORDER BY start_date DESC
                        LIMIT 1
                    );
                ';
        $results = Model::query_get_one_tran($sql, [$employee_no, $dayName, $employee_no]);

        return $results;
    }



    

}
