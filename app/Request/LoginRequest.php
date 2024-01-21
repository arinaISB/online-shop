<?php

namespace Request;

use Model\User;

class LoginRequest extends Request
{

    private User $modelUser;

    public function __construct(array $body)
    {
        parent::__construct($body);
        $this->modelUser = new User(0, '', '', '');
    }

    public function validate(): array
    {
        $password = $this->body['password'];
        $email = $this->body['email'];
        $user = $this->modelUser->getOneByEmail($email);
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (empty($this->body)) {
            $errors['email'] = 'You are not registered';
        } else {
            if (!password_verify($password, $user->getPassword())) {
                $errors['password'] = 'Invalid password or email';
            }
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