<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Request\PlaceOrderFormRequest;
use Resource\CartProductResource;
use Resource\CartResource;
use Service\AuthenticationService;

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

        list($cart, $viewData) = $this->extracted();

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

        if (empty($errors))
        {
            list($cart, $viewData) = $this->extracted();
            $placedOrderId = $this->createPlacedOrder($request, $viewData['totalPrice']);

            foreach ($viewData['products'] as $productInCart)
            {
                $product = CartProductResource::format($productInCart);
                OrderedCart::addOrderedItems($placedOrderId, $product['id'], $productInCart->getQuantity(), $product['lineTotal']);
                CartProduct::deleteProduct($cart->getId(), $product['id']);
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

        return PlacedOrder::addAndGetId($totalPrice, $email, $phone, $userName, $address, $city, $country, $postal);
    }

    public function check($userId, $cart, $productsInCart): array
    {
        $errors = [];
        if (empty($userId)) {
            $errors['userId'] = "User does not exist";
        } elseif (empty($cart)) {
            $errors['cart'] = "Cart does not exist";
        } elseif (empty($productsInCart)) {
            $errors['productsInCart'] = "Cart is empty";
        }

        return $errors;
    }

    /**
     * @return array|void
     */
    public function extracted()
    {
        $userId = $this->authenticationService->getCurrentUser()->getId();
        $cart = Cart::getOneByUserId($userId);
        $productsInCart = CartProduct::getAllByCartId($cart->getId());

        $errors = $this->check($userId, $cart, $productsInCart);

        if (!empty($errors)) {
            require_once './../View/place_order.php';
            exit;
        }

        $viewData = CartResource::format($cart);
        return array($cart, $viewData);
    }
}