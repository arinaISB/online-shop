<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Request\DeleteProductRequest;
use Service\CartViewService;


class CartController
{
    public function getCartForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cart = Cart::getCart($userId);
            $productsInCart = CartProduct::getProductsInCart($cart->getId());
            $viewData = CartViewService::viewProductsInCart($productsInCart);

            require_once './../View/cart.php';
        }
    }

    public function deleteProduct(DeleteProductRequest $request): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $errors = $request->validate();

            if (empty($errors))
            {
                $userId = $_SESSION['user_id'];
                $cart = Cart::getCart($userId);
                $productId = $request->getProductId();
                CartProduct::deleteProduct($cart->getId(), $productId);

                header("Location: /cart");
            }
        }
    }
}