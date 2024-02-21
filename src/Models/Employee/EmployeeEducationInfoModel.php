<?php

declare(strict_types=1);

namespace App\Models\Employee;


use App\Models\Model;


class EmployeeEducationInfoModel
{


    public static function storeTran(array $education_info): array
    {

        $sql = 'INSERT INTO public.employee_education_info(employee_id, academic_degree, unviersity, major, degree, edu_start_date, edu_end_date)
            VALUES ( ?, ?, ?, ?, ?, ?, ?)';

        $results = Model::query_set_tran($sql, $education_info);
        return $results;
    }
}
