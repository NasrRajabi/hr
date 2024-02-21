<?php

declare(strict_types=1);

namespace App\Models\Movement;


use App\Models\Model;


class MovementAddModel
{


    public static function store(array $basic_info): array
    {

        $sql = 'INSERT INTO movement(vehicle_id,itinerary, movement_date,driver, starting_hour, end_hour, star_counter_no,end_counter_no,movement_status,created_by,created_at)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?)';

        $results = Model::query_set($sql, $basic_info);
        return $results;
    }

    public static function viow_movement($id): array
    {

        $sql='select * 
        from movement
        where movement.id= ? ';
            $results =Model::query_get($sql,[$id]);

            return $results;
    }

    public static function updateMovement($vehicle_id, $itinerary,$movement_date, $driver,$starting_hour, $end_hour,$star_counter_no, $end_counter_no, $id ): array
    {
        
                $sql = "UPDATE movement SET vehicle_id=?, itinerary=?, movement_date=?, driver=?, starting_hour=?, end_hour=?, star_counter_no=?, end_counter_no=? WHERE id=?";

        return Model::query_up($sql, [$vehicle_id, $itinerary,$movement_date, $driver,$starting_hour, $end_hour,$star_counter_no, $end_counter_no, $id]);
    }
    public static function updateEndMovement($end_movement_date,$end_hour,$end_counter_no,$movement_status, $id ): array
    {
        
                $sql = "UPDATE movement SET end_movement_date=?, end_hour=?, end_counter_no=?, movement_status=? WHERE id=?";

        return Model::query_up($sql, [$end_movement_date, $end_hour, $end_counter_no,$movement_status, $id]);
    }
    
}
