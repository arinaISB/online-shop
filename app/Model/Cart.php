<?php

namespace Model;

class Cart extends Model
{
    protected ?int $id;
    protected ?int $userId;

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

    public static function create(int $userId): bool
    {
        $statement = static::getPdo()->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        return $statement->execute(['user_id' => $userId]);
    }

    public static function getOneByUserId(int $userId): Cart|null
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