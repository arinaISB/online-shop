<?php

namespace Service;

use Model\User;

interface AuthenticationInterface
{
    public function check(): bool;

    public function getCurrentUser(): User|null;
    public function login(string $password, string $email): bool;

    public function logout(): void;
}