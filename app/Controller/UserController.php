<?php

namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthenticationService;

class UserController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
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

            User::addUser($email, $name, $hashedPassword);

            $result = $this->authenticationService->login($password);
            if (!$result)
            {
                $errors['email'] = 'Invalid login or password';
            }

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

        if(empty($errors)) {
            $result = $this->authenticationService->login($request);

            if ($result) {
                header("Location: /main");
                exit;
            } else {
                $errors['email'] = 'Invalid password or email';
            }
        }

        require_once './../View/login.php';
    }


    public function logout(): void
    {
        $this->authenticationService->logout();

        header("Location: /login");
    }
}