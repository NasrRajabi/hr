<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Models\Model;


class EmployeeAddressesInfoModel
{


    public static function storeTran(array $address_info): array
    {

        $sql = 'INSERT INTO public.employee_addresses_info(employee_id, address, city, region, street, postal_code)
            VALUES (?, ?, ?, ?, ?, ?)';

        $results = Model::query_set_tran($sql, $address_info);
        return $results;
    }




}
