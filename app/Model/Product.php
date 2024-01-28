<?php

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private int $price;
    private string $link;

    public function __construct(int $id, string $name, int $price, string $link)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->link = $link;
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

    public static function getAll(): array|null
    {
        $statement = self::getPdo()->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        if (empty($products))
        {
            return null;
        }

        $result = [];
        foreach ($products as $product) {
            $result[] = new Product($product['id'], $product['name'], $product['price'], $product['link']);
        }

        return $result;
    }

    public static function getOneById(int $id): Product|null
    {
        $statement = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productInfo = $statement->fetch();

        if (empty($productInfo))
        {
            return null;
        }

        return new Product($productInfo['id'], $productInfo['name'], $productInfo['price'], $productInfo['link']);
    }
}