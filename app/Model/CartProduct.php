<?php

namespace Model;

class CartProduct extends Model
{
    public function addCartProducts(int $cartId, int $productId, int $quantity): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getCartProduct(int $cartId, int $productId): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
        return $statement->fetch();
    }
//    public function isProductInCart(int $cartId, int $productId): bool
//    {
//        $statement = $this->pdo->prepare("SELECT COUNT(*) FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
//        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
//        $result = $statement->fetchColumn();
//
//        return $result > 0;
//    }

//    public function getProductQuantity(int $cartId, int $productId): int
//    {
//        $statement = $this->pdo->prepare("SELECT quantity FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
//        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
//        return $statement->fetchColumn();
//    }

    public function updateProductQuantity($cartId, $productId, $newQuantity): bool
    {
        $statement = $this->pdo->prepare("UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND  product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $newQuantity]);
    }

    public function addCartProduct(int $cartId, int $productId, int $quantity): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getProductsInCart(int $cartId): false|array
    {
        $statement = $this->pdo->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
        $statement->execute(['cart_id' => $cartId]);
        return $statement->fetchAll();
    }

    public function deleteProduct(int $cartId, int $productId): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
    }

}