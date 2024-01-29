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

        $_SESSION['user_id'] = $user->getId();

        return true;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}