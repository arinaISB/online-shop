<?php

namespace Model;

class OrderedCart extends Model
{
    private int $id;
    private int $placedOrderId;
    private int $productId;
    private int $quantity;
    private int $productLineTotal;

    public function __construct(int $id, int $placedOrderId, int $productId, int $quantity, int $productLineTotal)
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

    public static function addOrderedItems(int $placedOrderId, int $productId, int $quantity, int $productLineTotal): array|null
    {
        $statement = self::getPdo()->prepare("INSERT INTO ordered_items (placed_order_id, product_id, quantity, line_total) VALUES (:placed_order_id, :product_id, :quantity, :line_total)");
        $statement->execute(['placed_order_id' => $placedOrderId, 'product_id' => $productId, 'quantity' => $quantity, 'line_total' => $productLineTotal]);
        $data = $statement->fetchAll();

        if (empty($data))
        {
            return null;
        }

        $result = [];
        foreach ($data as $product) {
            $result[] = new OrderedCart($product['id'], $product['placed_order_id'], $product['product_id'], $product['quantity'], $product['line_total']);
        }

        return $result;
    }
}