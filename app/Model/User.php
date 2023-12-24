<?php

namespace Model;

class User extends Model
{
    public function getOneByEmail(string $email): array | false
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        $result = $statement->fetch();

        return $result;
    }
}