<?php

namespace Service;

use Model\User;

class AuthenticationService
{
    private User $user;

    public function check(): bool
    {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): User|null
    {
        if (isset($this->user))
        {
            return $this->user;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id']))
        {
            $this->user = User::getById($_SESSION['user_id']);
            return $this->user;
        }

        return null;
    }

    public function login(string $password, string $email): bool
    {
        $user = User::getOneByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword()))
        {
            return false;
        }

        session_start();
        $_SESSION['user_id'] = $user->getId();

        return true;
    }

    public function logout(): void
    {
        session_start();
        unset($_SESSION['user_id']);
        session_destroy();
    }
}