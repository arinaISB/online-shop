<?php

namespace Controller;
use Model\Product;
use Service\AuthenticationService;

class MainController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getProducts(): void
    {
        $result = $this->authenticationService->check();

        if (!$result)
        {
            header("Location: /login");
        }

        $products = Product::getAll();

        require_once './../View/main.php';
    }
}