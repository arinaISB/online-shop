<?php

namespace Service;

use Model\User;

class AuthenticationService
{
    public function check(): bool
    {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): User|null
    {
//        if (!$this->check())
//        {
//            return null;
//        }

        return User::getById($_SESSION['user_id']);
    }

    public function login(string $password): bool
    {
        session_start();
        $user = $this->getCurrentUser();

        if (!$user)
        {
            return false;
        }

        if (!password_verify($password, $user->getPassword()))
        {
            return false;
        }

        $id = $user->getId();
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();
//        $_SESSION['user_id'] = $user->getId();

        return true;
    }
}