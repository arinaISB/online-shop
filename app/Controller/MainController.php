<?php

namespace Controller;
use Model\Product;

class MainController
{
    public function getProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            $products = Product::getAll();

            require_once './../View/main.php';
        }
    }
}