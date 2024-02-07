<?php

namespace Controller;

use Kivinus\MyCore\Service\Authentication\AuthenticationInterface;
use Exception;
use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;

class UserController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getRegistration(): void
    {
        require_once './../View/registration.php';
    }


    /**
     * @throws Exception
     */
    public function registration(RegistrationRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();

//            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//                throw new Exception("Invalid email address provided: $email");
//            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            User::add($email, $name, $hashedPassword);
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

        if (empty($errors)) {
            $password = $request->getPassword();
            $email = $request->getEmail();

            $result = $this->authenticationService->login($password, $email);

            if ($result) {
                header("Location: /main");
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