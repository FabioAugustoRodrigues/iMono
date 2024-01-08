<?php

namespace app\database;

use \PDO;
use PDOException;

abstract class Connection
{

    private static $connection;

    public static function getConnection()
    {
        if (self::$connection == null) {
            try {
                $dsn = sprintf("%s:host=%s;dbname=%s;charset=utf8", DB_DRIVER, DB_HOST, DB_NAME);
                self::$connection = new PDO($dsn, DB_USER, DB_PASS);

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}
