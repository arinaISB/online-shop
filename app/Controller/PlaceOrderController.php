<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Model\Product;
use Request\PlaceOrderFormRequest;
use Service\AuthenticationService;
use Service\CartViewService;

class PlaceOrderController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getPlaceOrderForm(): void
    {
        $result = $this->authenticationService->check();

        if (!$result)
        {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $cart = Cart::getCart($userId);
        $productsInCart = CartProduct::getProductsInCart($cart->getId());

        if (empty($productsInCart))
        {
            $errors = "Cart is empty";
        } else {
            $viewData = CartViewService::viewProductsInCart($productsInCart);
        }

        require_once './../View/place_order.php';

    }

    public function placeOrderForm(PlaceOrderFormRequest $request): void
    {
        $result = $this->authenticationService->check();

        if (!$result)
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        $userId = $_SESSION['user_id'];
        $cart = Cart::getCart($userId);
        $productsInCart = CartProduct::getProductsInCart($cart->getId());
        $totalPrice = CartViewService::calculateTotalPrice($productsInCart);
        $placedOrderId = $this->createPlacedOrder($request, $totalPrice);

        if (empty($errors)) {
            foreach ($productsInCart as $productInCart) {
                $productId = $productInCart->getProductId();
                $productInfo = Product::getProductInfo($productId);
                $productLineTotal = $productInCart->getQuantity() * $productInfo->getPrice();
                OrderedCart::addOrderedItems($placedOrderId, $productId, $productInCart->getQuantity(), $productLineTotal);
                CartProduct::deleteProduct($cart->getId(), $productId);
            }
            header("Location: /main");
        }
        require_once './../View/place_order.php';
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