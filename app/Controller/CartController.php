<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\DeleteProductRequest;


class CartController
{
    private Cart $cartModel;
    private CartProduct $cartProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

    public function getCartForm(): void
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
                $cart = $this->cartModel->getCart($userId);
                $productId = $request->getProductId();
                $this->cartProductModel->deleteProduct($cart['id'], $productId);

                header("Location: /cart");
            }
        }
    }
}