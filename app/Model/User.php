<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;


    public function __construct(int $id, string $name, string $email, string $password)
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
        return new User($result['id'], $result['name'], $result['email'], $result['password']);
    }

    public static function getById(int $id)
    {
        $statement = static::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        if (!$result)
        {
            return null;
        }

        return new User($result['id'], $result['name'], $result['email'], $result['password']);
    }

    public static function addUser(string $email, string $name, string $password): void
    {
        $statement = static::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}