<?php

namespace Model;

class CartProduct extends Model
{
    public function getCart(string $name, int $userId)
    {
        $existingStatement = $this->pdo->prepare("SELECT id FROM carts WHERE name = :name");
        $existingStatement->execute(['name' => $name]);
        $cart = $existingStatement->fetch();

        if (empty($cart)) {
            $insertStatement = $this->pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
            $insertStatement->execute(['name' => $name, 'user_id' => $userId]);

            return $this->pdo->lastInsertId();
        } else {
            return $cart['id'];
        }
    }

        public function addCartProducts(int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $newCartProduct = $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);

        return $newCartProduct;
    }
}