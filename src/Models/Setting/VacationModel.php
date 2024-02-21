<?php

namespace App\Models\Setting;

use App\Models\Model;

class VacationModel
{

    public static function  all(): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    vacation_setting 
                ORDER BY
                    vacation_type , contract_type';

        $results =Model::query_get($sql);

        return $results;
    }

    public static function  all_vac_type(): array
    {
        $sql = 'SELECT 
                    *  
                FROM 
                    vacation_type 
                ORDER BY
                    id ';

        $results =Model::query_get($sql);

        return $results;
    }

}

