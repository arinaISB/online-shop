<?php

namespace Controller;
use Model\Product;

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
            $products = $this->productModel->getAll();

            require_once './../View/main.php';
        }
    }


    public function getAddProductForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            require_once './../View/add-product.php';
        }
    }

    public function addProduct(array $data)
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cartName = $data['cart_name'];
            $productId = $data['product_id'];
            $quantity = $data['quantity'];

            $cart = $this->productModel->addProduct($cartName, $userId);

            $cartId = $this->productModel->findCartId();

            $cartProduct = $this->productModel->addCartProducts($cartId, $productId, $quantity);

            require_once './../View/add-product.php';
        }
    }
}