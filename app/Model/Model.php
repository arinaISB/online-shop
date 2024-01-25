<?php

namespace Model;
use PDO;

class Model
{
    protected static PDO $pdo;

    public static function pdoInitialize(): void
    {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_DATABASE');
        $dbuser= getenv('DB_USERNAME');
        $dbpassword = getenv('DB_PASSWORD');

        static::$pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", "$dbuser", "$dbpassword");
    }

    public static function getPdo(): PDO
    {
        if (!isset(static::$pdo))
        {
            static::pdoInitialize();
        }
        return static::$pdo;
    }
}