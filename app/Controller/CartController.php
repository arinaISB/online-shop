<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Request\DeleteProductRequest;


class CartController
{
    private Cart $cartModel;
    private CartProduct $cartProductModel;


    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
    }

    public function getCartForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cart = $this->cartModel->getCart($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cart['id']);

            require_once './../View/cart.php';
        }
    }

    public function deleteProduct(DeleteProductRequest $request)
    {
        if ($request->validate())
        {
            $userId = $_SESSION['user_id'];
            $cart = $this->cartModel->getCart($userId);
            $productId = $request->getProductId();
            $this->cartProductModel->deleteProduct($cart['id'], $productId);
            header("Location: /cart");
        } else {
            header("Location: /login");
        }
    }
}