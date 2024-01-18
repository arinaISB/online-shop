<?php

namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;

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

    public function registration(RegistrationRequest $request): void
    {
        $errors = $request->validate();

        if(empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->modelUser->addUser($email, $name, $hashedPassword);

            header("Location: /login");
        }
        require_once './../View/registration.php';
    }

    public function getLogin(): void
    {
        require_once './../View/login.php';
    }

    public function login(LoginRequest $request): void
    {
        $errors = $request->validate();

        if(empty($errors))
        {
            $password = $request->getPassword();
            $email = $request->getEmail();
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


    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        header("Location: /login");
    }
}