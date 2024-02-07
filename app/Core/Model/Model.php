<?php

namespace Core\Model;
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

    public static function hydrate(array $data): static
    {
        $obj = new static();

        foreach ($data as $key => $value)
        {
            $camelCaseKey = self::snakeToCamel($key);
            $obj->$camelCaseKey = $value;
        }

        return $obj;
    }

    protected static function snakeToCamel(string $input): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
    }
}