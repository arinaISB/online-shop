<?php

namespace Model;

class Cart extends Model
{
    public function createCart(int $userId): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        return $statement->execute(['user_id' => $userId]);
    }

    public function getCart(int $userId): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);

        return $statement->fetch();
    }
}