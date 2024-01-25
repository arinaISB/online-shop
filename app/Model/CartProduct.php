<?php

namespace Model;

class CartProduct extends Model
{
    private int $id;
    private int $cartId;
    private int $productId;
    private int $quantity;

    public function __construct(int $id, int $cartId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public static function addCartProducts(int $cartId, int $productId, int $quantity): bool
    {
        $statement = static::getPdo()->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getCartProduct(int $cartId, int $productId): CartProduct|false
    {
        $statement = self::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
        $data = $statement->fetch();

        if (!$data)
        {
            return false;
        }

        return new CartProduct($data['id'], $data['cart_id'], $data['product_id'], $data['quantity']);
    }

    public static function updateProductQuantity($cartId, $productId, $newQuantity): bool
    {
        $statement = self::getPdo()->prepare("UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND  product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $newQuantity]);
    }

    public static function getProductsInCart(int $cartId): array|null
    {
        $statement = self::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
        $statement->execute(['cart_id' => $cartId]);
        $products = $statement->fetchAll();

        if (empty($products))
        {
            return null;
        }

        $result = [];
        foreach ($products as $product) {
            $result[] = new CartProduct($product['id'], $product['cart_id'], $product['product_id'], $product['quantity']);
        }

        return $result;
    }

    public static function deleteProduct(int $cartId, int $productId): bool
    {
        $statement = self::getPdo()->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
    }
}