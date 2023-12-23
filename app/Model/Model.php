<?php

class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $dbname = getenv('DB_DATABASE');
        $dbuser= getenv('DB_USERNAME');
        $dbpassword = getenv('DB_PASSWORD');

        $this->pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", "$dbuser", "$dbpassword");
    }
}