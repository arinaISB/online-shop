<?php

namespace Request;

use Model\User;
use Service\AuthenticationService;

class LoginRequest extends Request
{
    public function validate(): array
    {
        $password = $this->body['password'];
        $email = $this->body['email'];
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    public function getPassword(): string
    {
        return $this->body['password'];
    }

    public function getEmail(): string
    {
        return $this->body['email'];
    }
}