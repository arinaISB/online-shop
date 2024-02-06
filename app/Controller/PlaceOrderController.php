<?php

namespace Controller;

use Exception;
use Exceptions\UserNotFoundExceptions;
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
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        list($cart, $viewData) = $this->extracted();

        require_once './../View/place_order.php';
    }

    public function placeOrder(PlaceOrderFormRequest $request): void
    {
        if (!$this->authenticationService->check())
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

    /**
     * @throws Exception
     */
    public function extracted(): array
    {
        try {
            $user= $this->authenticationService->getCurrentUser();
        } catch (UserNotFoundExceptions) {
            require_once './../View/500.php';
        }

        $userId = $user->getId();

        $cart = Cart::getOneByUserId($userId);

        if (empty($cart))
        {
            throw new Exception('Cart does not exist');
        }

        $productsInCart = CartProduct::getAllByCartId($cart->getId());

        if (empty($productsInCart))
        {
            throw new Exception('Cart is empty');
        }

        $viewData = CartResource::format($cart);

        return array($cart, $viewData);
    }
}