<?php

namespace Service;

use Model\User;
use Request\LoginRequest;

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
        if ($this->user)
        {
            return $this->user;
        }

        if (isset($_SESSION['user_id']))
        {
            $this->user = User::getById($_SESSION['user_id']);
            return $this->user;
        }

        return null;
    }

    public function login(LoginRequest $request): bool
    {
        $user = User::getOneByEmail($request->getEmail());

        if (!$user || !password_verify($request->getPassword(), $user->getPassword()))
        {
            return false;
        }

        $_SESSION['user_id'] = $user->getId();

        return true;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}