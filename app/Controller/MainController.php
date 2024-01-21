<?php

namespace Controller;
use Model\Product;

class MainController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product(0,'',0,'');
    }

    public function getProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            $products = $this->productModel->getAll();

            require_once './../View/main.php';
        }
    }
}