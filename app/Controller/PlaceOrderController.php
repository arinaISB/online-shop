<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlaceOrder;
use Model\Product;

class PlaceOrderController
{
    private Cart $cartModel;
    private CartProduct $cartProductModel;
    private Product $productModel;
    private PlaceOrder $placeOrder;
    private OrderedCart $orderedCart;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
        $this->productModel = new Product();
        $this->placeOrder = new PlaceOrder();
        $this->orderedCart = new OrderedCart();
    }

    public function getPlaceOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {

            $userId = $_SESSION['user_id'];
            $cartId = $this->cartModel->getCartId($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cartId);

            $productLinks = [];
            foreach ($productsInCart as $productInCart) {
                $link = $this->productModel->getProductLink($productInCart['product_id']);
                $productLinks[] = ['link' => $link];
            }

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

            require_once './../View/place_order.php';
        }
    }

    public function placeOrderForm(array $data)
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {

            $userId = $_SESSION['user_id'];
            $cartId = $this->cartModel->getCartId($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cartId);

            $productLinks = [];
            foreach ($productsInCart as $productInCart) {
                $link = $this->productModel->getProductLink($productInCart['product_id']);
                $productLinks[] = ['link' => $link];
            }

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

            $email = $data['checkout-email'];
            $phone = $data['checkout-phone'];
            $name = $data['checkout-name'];
            $address = $data['checkout-address'];
            $city = $data['checkout-city'];
            $country = $data['checkout-country'];
            $postal = $data['checkout-postal'];

            $contactInfo = $this->placeOrder->addContactInfo($email, $phone, $name, $address, $city, $country, $postal);

            $cartInfo = $this->orderedCart->addOrderedCart($cartId, $totalPrice);

            require_once './../View/place_order.php';
        }
    }


}