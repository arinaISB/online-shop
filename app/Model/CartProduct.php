<?php

namespace Model;

class CartProduct extends Model
{
    public function addCartProducts(int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $newCartProduct = $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);

        return $newCartProduct;
    }

    public function isProductInCart(int $cartId, int $productId)
    {
        $statement = $this->pdo->prepare("SELECT COUNT(*) FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
        $result = $statement->fetchColumn();

        return $result > 0;
    }

    public function getProductQuantity(int $cartId, int $productId)
    {
        $statement = $this->pdo->prepare("SELECT quantity FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
        $result = $statement->fetchColumn();

        return $result !== false ? $result : 0;
    }

    public function updateProductQuantity($cartId, $productId, $newQuantity)
    {
        $statement = $this->pdo->prepare("UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND  product_id = :product_id");
        $updateCartProduct = $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $newQuantity]);

        return $updateCartProduct;
    }

    public function addCartProduct(int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $newCartProduct = $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);

        return $newCartProduct;
    }}