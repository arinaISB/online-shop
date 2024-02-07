<?php

namespace Request;

use Core\Request\Request;
use Model\User;

class RegistrationRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        $name = $this->body['name'];
        if (strlen($name) < 2)
        {
            $errors['name'] = "The name must be more than two characters";
        } elseif (!ctype_alpha($name))
        {
            $errors['name'] = "The name can only contain alphabetic characters";
        }

        $email = $this->body['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors['email'] = "Email is invalid";
        } else
        {
            $existingUser = User::getOneByEmail($email);
            if ($existingUser) {
                $errors['email'] = "Email already exists";
            }
        }


        $password = $this->body['psw'];
        $repeatPassword = $this->body['psw-repeat'];

        if (strlen($password) < 8)
        {
            $errors['psw'] = "The password must contain at least 8 characters";

        } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password))
        {
            $errors['psw'] = "The password must contain at least one letter and one number";
        } elseif ($password !== $repeatPassword)
        {
            $errors['psw-repeat'] = "Password and repeat password do not match";
        }
        return $errors;
    }

    public function getName(): string
    {
        return $this->body['name'];
    }

    public function getEmail(): string
    {
        return $this->body['email'];
    }

    public function getPassword(): string
    {
        return $this->body['psw'];
    }
}