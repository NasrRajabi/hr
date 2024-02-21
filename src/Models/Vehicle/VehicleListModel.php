<?php

declare(strict_types=1);

namespace App\Models\Vehicle;


use App\Models\Model;


class VehicleListModel extends Model 
{
    public static function  all(): array
    {
        // $sql = 'SELECT vehicle.*, FROM vehicle' ;

        $sql = 'SELECT 
        *             
    FROM 
    vehicle';


        $results =Model::query_get($sql);
   
        return $results;
    }

  
            

}

