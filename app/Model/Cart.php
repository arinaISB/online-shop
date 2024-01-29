<?php

namespace Model;

class Cart extends Model
{
    private ?int $id;
    private ?int $userId;

    public function __construct(?int $id = null, ?int $userId = null)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public static function hydrate(array $data): static
    {
        return new static(
            $data['id'] ?? null,
            $data['userId'] ?? null,
        );
    }

    public static function createCart(int $userId): bool
    {
        $statement = static::getPdo()->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        return $statement->execute(['user_id' => $userId]);
    }

    public static function getCart(int $userId): Cart|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $result = $statement->fetch();

        if (!$result)
        {
            return null;
        }

        return static::hydrate($result);
    }
}