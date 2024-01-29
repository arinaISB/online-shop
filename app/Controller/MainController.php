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
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        $products = Product::getAll();

        if (empty($products))
        {
            echo "No products";
            exit;
        }

        $sum=0;
        if(isset($_POST['minus'])){
            $sum = $_POST['sum'];
            $sum--;
        }

        if(isset($_POST['add'])){
            $sum = $_POST['sum'];
            $sum++;
        }

        require_once './../View/main.php';
    }
}