<?php

namespace Model;

class Product extends Model
{
    public function getAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM products");
        return $statement->fetchAll();
    }

    public function getProductInfo(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }
}