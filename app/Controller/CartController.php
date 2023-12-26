<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;

class CartController
{
    private CartProduct $cartProductModel;
    private Cart $cartModel;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
    }

    public function getAddProductForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            require_once './../View/main.php';
        }
    }

    public function addProduct(array $data): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $productId = $data['product_id'];
            $quantity = $data['quantity'];

            $cartId = $this->cartModel->getCart($userId);
            $cartProduct = $this->cartProductModel->addCartProducts($cartId, $productId, $quantity);

            header("Location: /main");
        }
    }

    public function myCart()
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            require_once './../View/main.php';
        }
    }
}