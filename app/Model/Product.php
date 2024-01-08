<?php

namespace Model;

class Product extends Model
{
    public function getAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        return $products;
    }

    public function getProductLink($id)
    {
        $statement = $this->pdo->prepare("SELECT link FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productLink = $statement->fetchColumn();

        return $productLink;
    }

    public function getProductName($id)
    {
        $statement = $this->pdo->prepare("SELECT name FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productName = $statement->fetchColumn();

        return $productName;
    }

    public function getProductPrice($id)
    {
        $statement = $this->pdo->prepare("SELECT price FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productPrice = $statement->fetchColumn();

        return $productPrice;
    }

}