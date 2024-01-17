<?php

namespace Controller;
use Model\User;

class UserController
{
    private User $modelUser;

    public function __construct()
    {
        $this->modelUser = new User();
    }
    public function getRegistration(): void
    {
        require_once './../View/registration.php';
    }

    public function registration(array $data): void
    {
        $errors = $this->validateRegistrationForm($data);

        if(empty($errors)) {
            $name = $data['name'];
            $email = $data['email'];
            $password = $data['psw'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->modelUser->addUser($email, $name, $hashedPassword);

            header("Location: /login");
        }
        require_once './../View/registration.php';
    }

    private function validateRegistrationForm(array $data): array
    {
        $errors = [];

        $name = $data['name'];
        if (strlen($name) < 2)
        {
            $errors['name'] = "The name must be more than two characters";
        } elseif (!ctype_alpha($name))
        {
            $errors['name'] = "The name can only contain alphabetic characters";
        }

        $email = $data['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors['email'] = "Email is invalid";
        } else
            {
                $existingUser = $this->modelUser->getOneByEmail($email);
                if ($existingUser) {
                    $errors['email'] = "Email already exists";
                }
            }


        $password = $data['psw'];
        $repeatPassword = $data['psw-repeat'];

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

    public function getLogin(): void
    {
        require_once './../View/login.php';
    }

    public function login($data): void
    {
        $errors = $this->validateLoginForm($data);

        if(empty($errors))
        {
            $password = $data['password'];
            $email = $data['email'];
            $user = $this->modelUser->getOneByEmail($email);
            //setcookie('user_id', $data['id']);  небезопасно!
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: /main");
            }
        }
        require_once './../View/login.php';
    }

    private function validateLoginForm(array $data): array
    {
        $password = $data['password'];
        $email = $data['email'];

        $user = $this->modelUser->getOneByEmail($email);

        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (empty($data)) {
            $errors['email'] = 'You are not registered';
        } else {
            if (!password_verify($password, $user['password'])) {
                $errors['password'] = 'Invalid password or email';
            }
        }

        return $errors;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header("Location: /login");
    }
}