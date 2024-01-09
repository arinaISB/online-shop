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

//            var_dump($productsInCart); die;

            $productLinks = [];
            foreach ($productsInCart as $productInCart) {
                $link = $this->productModel->getProductLink($productInCart['product_id']);
                $productLinks[] = ['link' => $link];
            }

//            var_dump($productLinks); die;

            $productNames = [];
            foreach ($productsInCart as $productInCart) {
                $name = $this->productModel->getProductName($productInCart['product_id']);
                $productNames[] = ['name' => $name];
            }

            $productQuantity = [];
            foreach ($productsInCart as $productInCart) {
                $quantity = $this->cartProductModel->getProductQuantity($cartId, $productInCart['product_id']);
                $productQuantity[] = ['quantity' => $quantity];
            }

            $productLineTotal = [];
            foreach ($productsInCart as $productInCart) {
                $price = $this->productModel->getProductPrice($productInCart['product_id']);
                $lineTotal = $quantity * $price;
                $productLineTotal[] = ['lineTotal' => $lineTotal];
            }

            $totalPrice = 0;
            foreach ($productLineTotal as $item) {
                $totalPrice += $item['lineTotal'];
            }

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
                $productsInCart = $this->cartProductModel->getProductsInCart($cartId);

//            var_dump($productsInCart); die;

                $productLinks = [];
                foreach ($productsInCart as $productInCart) {
                    $link = $this->productModel->getProductLink($productInCart['product_id']);
                    $productLinks[] = ['link' => $link];
                }

//            var_dump($productLinks); die;

                $productNames = [];
                foreach ($productsInCart as $productInCart) {
                    $name = $this->productModel->getProductName($productInCart['product_id']);
                    $productNames[] = ['name' => $name];
                }

                $productQuantity = [];
                foreach ($productsInCart as $productInCart) {
                    $quantity = $this->cartProductModel->getProductQuantity($cartId, $productInCart['product_id']);
                    $productQuantity[] = ['quantity' => $quantity];
                }

                $productLineTotal = [];
                foreach ($productsInCart as $productInCart) {
                    $price = $this->productModel->getProductPrice($productInCart['product_id']);
                    $lineTotal = $quantity * $price;
                    $productLineTotal[] = ['lineTotal' => $lineTotal];
                }

                $totalPrice = 0;
                foreach ($productLineTotal as $item) {
                    $totalPrice += $item['lineTotal'];
                }


                $productId = $data['product_id'];
                $delete = $this->cartProductModel->deleteProduct($cartId, $productId);

            }

            header("Location: /cart");
            require_once './../View/cart.php';
        }
    }
}