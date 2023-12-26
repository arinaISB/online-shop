<?php

namespace Model;

class Cart extends Model
{
    public function getCart(int $userId)
    {
//        $existingStatement = $this->pdo->prepare("SELECT id FROM carts WHERE name = :name");
//        $existingStatement->execute(['name' => $name]);
//        $cart = $existingStatement->fetch();
//
//        if (empty($cart)) {
//            $insertStatement = $this->pdo->prepare("INSERT INTO carts (name, user_id) VALUES (:name, :user_id)");
//            $insertStatement->execute(['name' => $name, 'user_id' => $userId]);
//
//            return $this->pdo->lastInsertId();
//        } else {
//            return $cart['id'];
//        }

        $insertStatement = $this->pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        $insertStatement->execute(['user_id' => $userId]);

        return $this->pdo->lastInsertId();
    }
}