<?php

declare(strict_types=1);

namespace App\Models;

use PDO;
use App\DataObjects\DbConfig;
use App\Contracts\ModelInterface;
use App\Exception\ModelException;


class Model implements ModelInterface
{

    private static  ?PDO $connection;

    public static function conn_open(): PDO
    {
        $dbConfig = new DbConfig();
        $driver     = $dbConfig->driver;
        $host       = $dbConfig->host;
        $port       = $dbConfig->port;
        $dbname     = $dbConfig->database;
        $username   = $dbConfig->username;
        $password   = $dbConfig->password;
        $charset    = $dbConfig->charset;

        $dsn = "{$driver}:host={$host};port={$port};dbname={$dbname}";

        $options  = [
            PDO::ATTR_EMULATE_PREPARES   => true, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, //make the default fetch be an associative object
        ];

        return  new PDO($dsn, $username, $password, $options);
    }
    public static function conn_close(): void
    {
        self::$connection = null;
    }
    /**
     * @author Asem Yamak
     * execute query via prepare and bind if prame is pass
     * fetch results
     * close connection
     */
    public static function query_get(string $sql, array $bindParam = null): array
    {
        try {

            self::$connection = self::conn_open();
            $stmt = self::$connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $results["status"] = (bool) $stmt->execute($bindParam);
            $data = $stmt->fetchAll();
            $results["rowCount"]  = (int) count($data);

            $results["result"] = $data;

            self::conn_close();
            return $results;
        } catch (\PDOException $exception) {
            self::errorHandler($exception, 'DB Model get (SQL) Error(s)');
        }
    }
    /**
     * @author Asem Yamak
     * execute query via prepare and bind if prame is pass
     * fetch results
     * close connection
     */
    public static function query_get_one(string $sql, array $bindParam = null): array
    {
        try {

            self::$connection = self::conn_open();
            $stmt = self::$connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $results["status"] = (bool) $stmt->execute($bindParam);
            $data = $stmt->fetchAll();
            $results["rowCount"]  = (int) count($data);

            if ($results["rowCount"] === 1) {
                $results["result"]  = $data[0];
            } else {
                $results["result"]  = $data;
            }

            self::conn_close();
            return $results;
        } catch (\PDOException $exception) {
            self::errorHandler($exception, 'DB Model get (SQL) Error(s)');
        }
    }

    /**
     * @author Asem Yamak
     * execute query via prepare and bind if prame is pass
     * fetch results
     * closeconnection
     */
    public static function query_set(string $sql, array $bindParam = null): array
    {
        try {
            self::$connection = self::conn_open();
            $stmt = self::$connection->prepare($sql);
            $results['status']          = (bool) $stmt->execute($bindParam);
            $results['lastInsertId']    = (int) self::$connection->lastInsertId();
            $results['rowCount']        = (int) $stmt->rowCount();
            self::conn_close();
            return $results;
        } catch (\PDOException $exception) {
            self::errorHandler($exception, 'DB Model set (SQL) Error(s)');
        }
    }

    /**
     * @author Asem Yamak
     * execute query via prepare and bind if prame is pass
     * fetch results
     * closeconnection
     */
    public static function query_up(string $sql, array $bindParam = null): array
    {
        try {
            self::$connection = self::conn_open();
            $stmt = self::$connection->prepare($sql);
            $results['status']          = (bool) $stmt->execute($bindParam);
            $results['rowCount']        = (int) $stmt->rowCount();
            self::conn_close();
            return $results;
        } catch (\PDOException $exception) {
            self::errorHandler($exception, 'DB Model set (SQL) Error(s)');
        }
    }



    public static  function start_tran(): void
    {
        
            self::$connection = self::conn_open();
            self::$connection->beginTransaction();
        
    }
    public static  function save_tran(): void
    {
        
            self::$connection->commit();
            self::conn_close();
        
    }
    public static  function rollBack_tran(): void
    {
        self::$connection->rollBack();
        self::conn_close();
    }
    public static function query_set_tran(string $sql, array $bindParam = null): array
    {

        try {

            $stmt = self::$connection->prepare($sql);
            $results['status']          = (bool) $stmt->execute($bindParam);
            $results['lastInsertId']    = (int) self::$connection->lastInsertId();
            $results['rowCount']        = (int) $stmt->rowCount();

            return $results;
        } catch (\PDOException $exception) {
            self::rollBack_tran();
            self::errorHandler($exception, 'DB Model Transaction (SQL) Error(s)');
        }
    }
    public static function query_get_tran(string $sql, array $bindParam = null): array
    {
        try {

            $stmt = self::$connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $results["status"] = (bool) $stmt->execute($bindParam);
            $data = $stmt->fetchAll();
            $results["rowCount"]  = (int) count($data);

            $results["result"] = $data;

            return $results;
        } catch (\PDOException $exception) {
            self::rollBack_tran();
            self::errorHandler($exception, 'DB Model Transaction (SQL) Error(s)');
        }
    }
    public static function query_get_one_tran(string $sql, array $bindParam = null): array
    {
        try {

            $stmt = self::$connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $results["status"] = (bool) $stmt->execute($bindParam);
            $data = $stmt->fetchAll();
            $results["rowCount"]  = (int) count($data);

            if ($results["rowCount"] === 1) {
                $results["result"]  = $data[0];
            } else {
                $results["result"]  = $data;
            }
            
            return $results;
        } catch (\PDOException $exception) {
            self::rollBack_tran();
            self::errorHandler($exception, 'DB Model Transaction (SQL) Error(s)');
        }
    }
    public static function query_up_tran(string $sql, array $bindParam = null): array
    {

        try {

            $stmt = self::$connection->prepare($sql);
            $results['status']          = (bool) $stmt->execute($bindParam);
            $results['rowCount']        = (int) $stmt->rowCount();

            return $results;
        } catch (\PDOException $exception) {
            self::rollBack_tran();
            self::errorHandler($exception, 'DB Model Transaction (SQL) Error(s)');
        }
    }



    /**
     * @author Asem Yamak
     * Handler for database Exception
     * Sends an error message to the web server's error log
     * you can redirect to anthor error page and exit
     */
    public static function errorHandler(\PDOException $exception, ?string $message = null): void
    {
        //write in error log or display exception
        // dd($Exception->getMessage()); //Sends an error message to the web server's error log or to a file you choose
        /*
            if ($this->$_env) {
                exit($Exception->getMessage()); //for development environment
            } else {
                exit('Something weird happened');         //something a user can understand for production environment
            }*/
        dd($exception->getMessage());
        throw new ModelException($message . '' . $exception->getMessage());
    }
}
