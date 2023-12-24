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

    public function addProduct(string $name, int $userId)
    {
        $existingStatement = $this->pdo->prepare("SELECT * FROM carts WHERE name = :name");
        $existingStatement->execute(['name' => $name]);
        $count = $existingStatement->fetch();

        if (empty($count)) {
            $statement = $this->pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
            $newProduct = $statement->execute(['name' => $name, 'user_id' => $userId]);

            return $newProduct;
        } else {
            return false; //доделать вывод ошибки
        }
    }

    public function findCartId()
    {
        $statement = $this->pdo->query("SELECT id FROM carts ORDER BY id DESC LIMIT 1");
        $cartIds = $statement->fetch();
        $cartId = $cartIds[0];

        return $cartId;
    }

    public function addCartProducts(int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $newCartProduct = $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);

        return $newCartProduct;
    }
}