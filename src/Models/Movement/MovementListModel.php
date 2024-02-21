<?php

declare(strict_types=1);

namespace App\Models\Movement;


use App\Models\Model;


class MovementListModel extends Model 
{
    public static function  all(): array
    {
        // $sql = 'SELECT vehicle.*, FROM vehicle' ;

        $sql = 'SELECT 
        *             
    FROM 
    movement';


        $results =Model::query_get($sql);
   
        return $results;
    }

  
            

}

