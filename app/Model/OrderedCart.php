<?php

namespace Model;

class OrderedCart extends Model
{
    public function addOrderedCart($cartId, $totalPrice)
    {
        $statement = $this->pdo->prepare("INSERT INTO ordered_carts (cart_id, total) VALUES (:cart_id, :total)");
        $statement->execute(['cart_id' => $cartId, 'total' => $totalPrice]);
        $result = $statement->fetchAll();

        return $result;
    }
}