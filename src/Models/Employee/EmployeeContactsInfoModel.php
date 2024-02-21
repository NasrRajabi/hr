<?php

declare(strict_types=1);

namespace App\Models\Employee;


use App\Models\Model;


class EmployeeContactsInfoModel
{


    public static function storeTran(array $contacts_info): array
    {

        $sql = 'INSERT INTO public.employee_contacts_info(employee_id, p_email, p_mobile, p_telephone, g_email, g_mobile, g_telephone)
                VALUES (?, ?, ?, ?, ?, ?, ?)';

        $results = Model::query_set_tran($sql, $contacts_info);
        return $results;
    }

    public static function all(): array
    {
        $sql = 'SELECT *
        FROM employee_basic_info AS basic 
        JOIN employee_contacts_info AS contact ON basic.id = contact.employee_id
        WHERE basic.id = contact.employee_id AND basic.employee_status = 1
        ORDER BY  contact.employee_id DESC
        ';


        $results = Model::query_get($sql);
        return $results;
    }

    public static function update_gov_email(int $id, string $email): array
    {
        $sql = 'UPDATE employee_contacts_info
                SET  g_email=?
                WHERE employee_id=? ';

        $results = Model::query_up($sql, [$email , $id]);
        return $results; 
    }
}

