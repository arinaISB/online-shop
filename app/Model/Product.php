<?php

namespace Model;

class Product extends Model
{
    protected ?int $id;
    protected ?string $name;
    protected ?int $price;
    protected ?string $link;

    public function __construct(?int $id = null, ?string $name = null, ?int $price = null, ?string $link = null)
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

    public static function getAll(): array
    {
        $statement = static::getPdo()->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        $result = [];
        foreach ($products as $product) {
            $result[] = static::hydrate($product);
        }

        return $result;
    }

    public static function getOneById(int $id): Product|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productInfo = $statement->fetch();

        if (empty($productInfo))
        {
            return null;
        }

        return static::hydrate($productInfo);
    }
}