<?php

namespace Model;

class Cart extends Model
{
    public function createCart(int $userId)
    {
        $statement = $this->pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        $newCart = $statement->execute(['user_id' => $userId]);

        return $newCart;
    }

    public function getCartId(int $userId)
    {
        $statement = $this->pdo->prepare("SELECT id FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $result = $statement->fetch();

        return $result !== false ? $result['id'] : null;
    }

    public function isCartExist(int $userId)
    {
        $statement = $this->pdo->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $result = $statement->fetch();

        return !empty($result);
    }
}