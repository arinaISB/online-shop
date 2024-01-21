<?php

namespace Model;

class CartProduct extends Model
{
    public function addCartProducts(int $cartId, int $productId, int $quantity): bool
    {
        $statement = self::getPdo()->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getCartProduct(int $cartId, int $productId): array|false
    {
        $statement = self::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
        return $statement->fetch();
    }

    public function updateProductQuantity($cartId, $productId, $newQuantity): bool
    {
        $statement = self::getPdo()->prepare("UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND  product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $newQuantity]);
    }

    public function getProductsInCart(int $cartId): false|array
    {
        $statement = self::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
        $statement->execute(['cart_id' => $cartId]);
        return $statement->fetchAll();
    }

    public function deleteProduct(int $cartId, int $productId): bool
    {
        $statement = self::getPdo()->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
    }

}