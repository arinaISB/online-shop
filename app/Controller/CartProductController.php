<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Request\AddProductRequest;
use Request\Request;

class CartProductController
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

    public function addProduct(AddProductRequest $request): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            if ($request->validateData())
            {
                $productId = $request->getProductId();
                $quantity = $request->getQuantity();

                $userId = $_SESSION['user_id'];
                $cart = $this->cartModel->getCart($userId);

                if (!empty($cart)) {
                    $cartProduct = $this->cartProductModel->getCartProduct($cart['id'], $productId);

                    if (empty($cartProduct)) {
                        $this->cartProductModel->addCartProducts($cart['id'], $productId, $quantity);
                    } else {
                        $currentQuantity = $cartProduct['quantity'];
                        $newQuantity = $currentQuantity + $quantity;
                        $this->cartProductModel->updateProductQuantity($cart['id'], $productId, $newQuantity);
                    }
                } else {
                    $this->cartModel->createCart($userId);
                    $cart = $this->cartModel->getCart($userId);
                    $this->cartProductModel->addCartProducts($cart['id'], $productId, $quantity);
                }

                header("Location: /main");
            }

        }
    }
}