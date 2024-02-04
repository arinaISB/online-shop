<?php

namespace Service;

use Model\User;

class CookieAuthenticationService implements AuthenticationInterface
{
    private User $user;

    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): User|null
    {
        if (isset($this->user))
        {
            return $this->user;
        }

        if (isset($_COOKIE['user_id']))
        {
            $this->user = User::getById($_COOKIE['user_id']);
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

        setcookie('user_id', $user->getId(), time() + (86400 * 30), '/');
        return true;
    }

    public function logout(): void
    {
       if ($this->check())
       {
           setcookie('user_id', $_COOKIE['user_id'], time() - 3600);
           header('Location: /login');
       }
    }
}