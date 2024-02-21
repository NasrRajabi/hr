<?php

namespace App\Models\Attendance;

use App\Models\Model;

class DevicesModel
{

    public static function  all(): array
    {
        $sql = 'SELECT *  FROM devices';
        $results = Model::query_get($sql);

        return $results;
    }

    public static function last_device_id(): array
    {

        $sql = 'SELECT MAX(id) as last_id
        FROM devices';

        return Model::query_get_one($sql);
    }

    public static function store(string $name, string $device_ip,   string $area): array
    {

        $sql = "  INSERT INTO devices( name, device_ip,   area ) 
                    VALUES
                        (?, ?, ? )";
        $results = Model::query_set($sql, [$name,  $device_ip,    $area]);

        return $results;
    }
    public static function update(int $id, string $name, string $device_ip,   string $area): array
    {
        $sql = 'UPDATE devices
                SET  name=?, device_ip=?, area=?
                WHERE id=?';

        $results = Model::query_set($sql, [$name,  $device_ip,  $area, $id]);

        return $results;
    }

    public static function findByIP(string $device_ip): array
    {
        $sql = 'SELECT * FROM devices WHERE device_ip=?';

        $results = Model::query_get_one($sql, [$device_ip]);

        return $results;
    }
}
