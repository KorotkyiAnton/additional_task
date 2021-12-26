<?php

namespace Models;

use PDO;

class DBSingleton
{
    private static PDO $db;

    private function __construct()
    {
    }

    public static function initiateDb(): void
    {
        try {
            static::$db = new PDO("mysql:host=127.0.0.1;dbname=korotkyianton", "root","");
        } catch (\PDOException $error) {
            throw new \PDOException($error->getMessage(), $error->getCode());
        }
    }

    public static function getDb()
    {
        if (static::$db !== null) {
            return static::$db;
        }
    }
}