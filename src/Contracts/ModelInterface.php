<?php

declare(strict_types = 1);

namespace App\Contracts;



interface ModelInterface
{
    public static function conn_open(): \PDO;
    public static function conn_close(): void;
    public static function query_get(string $sql, array $bindParam = null): array;
    public static function query_get_one(string $sql, array $bindParam = null): array;
    public static function query_set(string $sql, array $bindParam = null): array;
    public static function query_set_tran(string $sql, array $bindParam = null): array;
    public static function query_get_tran(string $sql, array $bindParam = null): array;
    public static function query_get_one_tran(string $sql, array $bindParam = null): array;
    public static function start_tran(): void;
    public static function save_tran(): void;
    public static  function rollBack_tran(): void;
    public static function errorHandler(\PDOException $exception, ?string $message = null): void;

}