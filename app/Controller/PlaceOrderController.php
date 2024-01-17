<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Model\Product;

class PlaceOrderController
{
    private Cart $cartModel;
    private CartProduct $cartProductModel;
    private Product $productModel;
    private PlacedOrder $placedOrder;
    private OrderedCart $orderedCart;

    public function __construct()
    {
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
        $this->productModel = new Product();
        $this->placedOrder = new PlacedOrder();
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
            $cart = $this->cartModel->getCart($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cart['id']);
            $totalPrice = $this->calculateTotalPrice($productsInCart);

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
            $cart = $this->cartModel->getCart($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cart['id']);
            $totalPrice = $this->calculateTotalPrice($productsInCart);
            $placedOrderId = $this->createPlacedOrder($data, $totalPrice);

            foreach ($productsInCart as $productInCart) {
                $productId = $productInCart['product_id'];
                $quantity = $productInCart['quantity'];
                $productInfo = $this->productModel->getProductInfo($productId);
                $productLineTotal = $quantity * $productInfo['price'];
                $this->orderedCart->addOrderedItems($placedOrderId, $productId, $quantity, $productLineTotal);
                $this->cartProductModel->deleteProduct($cart['id'], $productId);
            }

            header("Location: /main");
        }
    }

    private function calculateTotalPrice($productsInCart): float|int
    {
        $totalPrice = 0;

        foreach ($productsInCart as $productInCart) {
            $productId = $productInCart['product_id'];
            $productInfo = $this->productModel->getProductInfo($productId);
            $quantity = $productInCart['quantity'];
            $productLineTotal = $quantity * $productInfo['price'];
            $totalPrice += $productLineTotal;
        }
        return $totalPrice;
    }

    private function createPlacedOrder($data, $totalPrice): string
    {
        $email = $data['checkout-email'];
        $phone = $data['checkout-phone'];
        $userName = $data['checkout-name'];
        $address = $data['checkout-address'];
        $city = $data['checkout-city'];
        $country = $data['checkout-country'];
        $postal = $data['checkout-postal'];

        return $this->placedOrder->addAndGetPlacedOrder($totalPrice, $email, $phone, $userName, $address, $city, $country, $postal);
    }
}