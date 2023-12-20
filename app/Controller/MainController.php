<?php

require_once './../Model/Product.php';

class MainController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");

            $products = $this->productModel->getAll();

            require_once './../View/main.php';
        }
    }
}