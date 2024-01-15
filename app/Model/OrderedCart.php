<?php

namespace Model;

class OrderedCart extends Model
{
    public function addOrderedItems(int $placedOrderId, int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO ordered_items (placed_order_id, cart_id, product_id, quantity) VALUES (:placed_order_id, :cart_id, :product_id, :quantity)");
        $statement->execute(['placed_order_id' => $placedOrderId, 'cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
        $result = $statement->fetchAll();

        return $result;
    }
}