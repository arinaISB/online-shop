<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;

class CartController
{
    private CartProduct $cartProductModel;
    private Cart $cartModel;
    private Product $productModel;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
        $this->productModel = new Product();
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
}