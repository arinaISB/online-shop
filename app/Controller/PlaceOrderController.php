<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\PlacedOrder;
use Request\PlaceOrderFormRequest;
use Resource\CartResource;
use Service\AuthenticationInterface;
use Service\OrderService;

class PlaceOrderController
{
    private AuthenticationInterface $authenticationService;
    private OrderService $orderService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        $this->orderService = new OrderService();
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

    public function placeOrder(PlaceOrderFormRequest $request): void
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
            $order = new PlacedOrder(null, $viewData['totalPrice'], $request->getEmail(), $request->getPhone(), $request->getName(), $request->getAddress(), $request->getCity(), $request->getPostal());
            $this->orderService->create($order, $this->authenticationService->getCurrentUser());

            header("Location: /main");
        }

        require_once './../View/place_order.php';
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