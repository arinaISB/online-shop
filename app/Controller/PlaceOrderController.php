<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Model\Product;
use Request\PlaceOrderFormRequest;

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

    public function placeOrderForm(PlaceOrderFormRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $errors = $request->validate();//доделать

            $userId = $_SESSION['user_id'];
            $cart = $this->cartModel->getCart($userId);
            $productsInCart = $this->cartProductModel->getProductsInCart($cart['id']);
            $totalPrice = $this->calculateTotalPrice($productsInCart);
            $placedOrderId = $this->createPlacedOrder($request, $totalPrice);

            if (empty($errors)) {
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
            require_once './../View/place_order.php';
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

    private function createPlacedOrder(PlaceOrderFormRequest $request, $totalPrice): string
    {
        $email = $request->getEmail();
        $phone = $request->getPhone();
        $userName = $request->getName();
        $address = $request->getAddress();
        $city = $request->getCity();
        $country = $request->getCountry();
        $postal = $request->getPostal();

        return $this->placedOrder->addAndGetPlacedOrder($totalPrice, $email, $phone, $userName, $address, $city, $country, $postal);
    }
}