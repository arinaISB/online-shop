<?php

namespace Model;

class Product extends Model
{
//    private int $id;
//    private string $name;
//    private int $price;
//
//
//    public function __construct(int $id, string $name, int $price, string $link)
//    {
//        parent::__construct();
//        $this->id = $id;
//        $this->name = $name;
//        $this->price = $price;
//        $this->link = $link;
//    }

    public function getAll()
    {
        $statement = self::getPdo()->prepare("SELECT * FROM products");
        $statement->execute();
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }
        return $result;
//        return new Product($result['id'], $result['name'], $result['price'], $result['link']);
    }

    public function getProductInfo(int $id)
    {
        $statement = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }


    public function getLink(): string
    {
        return $this->link;
    }

    private string $link;
}