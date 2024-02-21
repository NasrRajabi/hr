<?php

use Doctrine\DBAL\DriverManager;

return DriverManager::getConnection([
    'dbname' => 'hr',
    'user' => 'root',
    'password' => 'root',
    'host' => '192.168.0.2',
    'port' => 5432,
    'charset'  => 'utf8mb4',
    'driver' => 'pgsql',
    'schema'   => 'public',
]);