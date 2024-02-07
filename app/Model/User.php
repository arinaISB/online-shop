<?php

namespace Model;

use Kivinus\MyCore\Model\Model;

class User extends Model
{
    protected ?int $id;
    protected ?string $name;
    protected ?string $email;
    protected ?string $password;

    public function __construct(?int $id = null, ?string $name = null, ?string $email = null, ?string $password = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function getOneByEmail(string $email): User|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        $result = $statement->fetch();

        if (empty($result)) {
            return null;
        }

        return static::hydrate($result);
    }

    public static function getById(int $id): User|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        if (!$result)
        {
            return null;
        }

        return static::hydrate($result);
    }

    public static function add(string $email, string $name, string $password): void
    {
        $statement = static::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}