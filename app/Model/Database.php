<?php

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}