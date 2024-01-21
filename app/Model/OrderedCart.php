<?php

namespace Model;

class OrderedCart extends Model
{
    public function addOrderedItems(int $placedOrderId, int $productId, int $quantity, int $productLineTotal): false|array
    {
        $statement = $this->pdo->prepare("INSERT INTO ordered_items (placed_order_id, product_id, quantity, line_total) VALUES (:placed_order_id, :product_id, :quantity, :line_total)");
        $statement->execute(['placed_order_id' => $placedOrderId, 'product_id' => $productId, 'quantity' => $quantity, 'line_total' => $productLineTotal]);
        $result = $statement->fetchAll();

        return $result;
    }
}