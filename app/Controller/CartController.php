<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;

class CartController
{
    private $cartModel;
    private $cartProductModel;
    private $productModel;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

    public function getCartForm()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cartId = $this->cartModel->getCartId($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cartId);

            require_once './../View/cart.php';
        }
    }

    public function deleteProduct(array $data)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            if (isset($data['product_id']))
            {
                $userId = $_SESSION['user_id'];
                $cartId = $this->cartModel->getCartId($userId);
                $productId = $data['product_id'];
                $this->cartProductModel->deleteProduct($cartId, $productId);
            }
            header("Location: /cart");
        }
    }
}