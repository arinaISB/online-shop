<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Model\Product;
use Request\PlaceOrderFormRequest;
use Service\CartViewService;

class PlaceOrderController
{
    public function getPlaceOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cart = Cart::getCart($userId);
            $productsInCart = CartProduct::getProductsInCart($cart->getId());
            $viewData = CartViewService::viewProductsInCart($productsInCart);

            require_once './../View/place_order.php';
        }
    }

    public function placeOrderForm(PlaceOrderFormRequest $request): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $errors = $request->validate();

            $userId = $_SESSION['user_id'];
            $cart = Cart::getCart($userId);
            $productsInCart = CartProduct::getProductsInCart($cart->getId());
            $totalPrice = CartViewService::calculateTotalPrice($productsInCart);
            $placedOrderId = $this->createPlacedOrder($request, $totalPrice);

            if (empty($errors)) {
                foreach ($productsInCart as $productInCart) {
                    $productId = $productInCart['product_id'];
                    $productInfo = Product::getProductInfo($productId);
                    $productLineTotal = $productInCart['quantity'] * $productInfo->getPrice();
                    OrderedCart::addOrderedItems($placedOrderId, $productId, $productInCart['quantity'], $productLineTotal);
                    CartProduct::deleteProduct($cart->getId(), $productId);
                }
                header("Location: /main");
            }
            require_once './../View/place_order.php';
        }
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

        return PlacedOrder::addAndGetPlacedOrder($totalPrice, $email, $phone, $userName, $address, $city, $country, $postal);
    }
}