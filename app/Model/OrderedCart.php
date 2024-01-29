<?php

namespace Model;

class OrderedCart extends Model
{
    private ?int $id;
    private ?int $placedOrderId;
    private ?int $productId;
    private ?int $quantity;
    private ?int $productLineTotal;

    public function __construct(?int $id = null, ?int $placedOrderId = null, ?int $productId = null, ?int $quantity = null, ?int $productLineTotal = null)
    {
        $this->id = $id;
        $this->placedOrderId = $placedOrderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->productLineTotal = $productLineTotal;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlacedOrderId(): int
    {
        return $this->placedOrderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProductLineTotal(): int
    {
        return $this->productLineTotal;
    }

    public static function hydrate(array $data): static
    {
        return new static(
            $data['id'] ?? null,
            $data['placedOrderId'] ?? null,
            $data['productId'] ?? null,
            $data['quantity'] ?? null,
            $data['productLineTotal'] ?? null,
        );
    }

    public static function addOrderedItems(int $placedOrderId, int $productId, int $quantity, int $productLineTotal): OrderedCart|null
    {
        $statement = static::getPdo()->prepare("INSERT INTO ordered_items (placed_order_id, product_id, quantity, line_total) VALUES (:placed_order_id, :product_id, :quantity, :line_total)");
        $statement->execute(['placed_order_id' => $placedOrderId, 'product_id' => $productId, 'quantity' => $quantity, 'line_total' => $productLineTotal]);
        $result = $statement->fetch();

        if (empty($result))
        {
            return null;
        }

        return static::hydrate($result);
    }
}