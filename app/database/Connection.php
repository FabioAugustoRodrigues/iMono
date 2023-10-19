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
                self::$connection = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPass);

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