<?php

declare(strict_types=1);

namespace App\Models\Vehicle;


use App\Models\Model;


class VehicleAddModel
{


    public static function store(array $basic_info): array
    {

        $sql = 'INSERT INTO vehicle(vehicle_no,vehicle_name, vehicle_type,chassis_no, engine_no, engine_capacity, vehicle_model,fuel_type,lime_type,vehicle_color,created_by,created_at)
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';

        $results = Model::query_set($sql, $basic_info);
        return $results;
    }

    public static function viow_vehicle($id): array
    {

        $sql='select * 
        from vehicle
        where vehicle.id= ? ';
            $results =Model::query_get($sql,[$id]);

            return $results;
    }

    public static function updateVehicle($vehicle_no, $vehicle_name,$vehicle_type, $chassis_no,$engine_no, $engine_capacity,$vehicle_model, $fuel_type,$lime_type,$vehicle_color, $id ): array
    {
        $sql = "UPDATE vehicle SET vehicle_no=?, vehicle_name=?, vehicle_type=?, chassis_no=?, engine_no=?, engine_capacity=?, vehicle_model=?, fuel_type=?, lime_type=?, vehicle_color=? WHERE id=?";

        return Model::query_up($sql, [$vehicle_no, $vehicle_name,$vehicle_type, $chassis_no,$engine_no, $engine_capacity,$vehicle_model, $fuel_type,$lime_type,$vehicle_color, $id]);
    }
    
}
