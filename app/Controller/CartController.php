<?php

namespace Controller;
use Model\CartProduct;

class CartController
{
    private CartProduct $cartProductModel;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
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

            $cartId = $this->cartProductModel->getCart($cartName, $userId);
            $cartProduct = $this->cartProductModel->addCartProducts($cartId, $productId, $quantity);

            require_once './../View/add-product.php';
        }
    }
}