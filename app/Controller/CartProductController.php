<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;

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

            if ($this->cartModel->isCartExist($userId)) {
                $cartId = $this->cartModel->getCartId($userId);

                if ($this->cartProductModel->isProductInCart($cartId, $productId)) {
                    $currentQuantity = $this->cartProductModel->getProductQuantity($cartId, $productId);
                    $newQuantity = $currentQuantity + $quantity;
                    $this->cartProductModel->updateProductQuantity($cartId, $productId, $newQuantity);
                } else {
                    $this->cartProductModel->addCartProduct($cartId, $productId, $quantity);
                }
            } else {
                $this->cartModel->createCart($userId);
                $cartId = $this->cartModel->getCartId($userId);
                $this->cartProductModel->addCartProducts($cartId, $productId, $quantity);
            }
            header("Location: /main");
        }
    }


}