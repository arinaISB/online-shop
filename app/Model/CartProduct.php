<?php

namespace Model;

class CartProduct extends Model
{
    private ?int $id;
    private ?int $cartId;
    private ?int $productId;
    private ?int $quantity;

    public function __construct(?int $id = null, ?int $cartId  = null, ?int $productId = null, ?int $quantity = null)
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

    public static function hydrate(array $data): static
    {
        return new static(
            $data['id'] ?? null,
            $data['cartId'] ?? null,
            $data['productId'] ?? null,
            $data['quantity'] ?? null,
        );
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
        $result = $statement->fetch();

        if (!$result)
        {
            return false;
        }

//        return new CartProduct($data['id'], $data['cart_id'], $data['product_id'], $data['quantity']);
        return static::hydrate($result);
    }

    public static function updateProductQuantity($cartId, $productId, $newQuantity): bool
    {
        $statement = static::getPdo()->prepare("UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND  product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $newQuantity]);
    }

    public static function getAllByCartId(int $cartId): array|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
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
        $statement = static::getPdo()->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
    }
}