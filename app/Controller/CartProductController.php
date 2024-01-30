<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Request\EditQuantityProductRequest;
use Service\AuthenticationService;

class CartProductController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getAddProductForm(): void
    {
        $result = $this->authenticationService->check();
        if (!$result)
        {
            header("Location: /login");
        }

        require_once './../View/main.php';
    }

    public function editQuantity(EditQuantityProductRequest $request): void
    {
        $result = $this->authenticationService->check();
        if (!$result)
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors))
        {
            $productId = $request->getProductId();
            $userId = $this->authenticationService->getCurrentUser()->getId();
            $cart = Cart::getOneByUserId($userId);
            $action = $request->getAction();

            if ($cart && ($action === 'minus' || $action === 'add')) {
                $cartProduct = CartProduct::get($cart->getId(), $productId);

                if ($action === 'minus') {
                    if ($cartProduct && $cartProduct->getQuantity() > 1) {
                        $newQuantity = $cartProduct->getQuantity() - 1;
                        CartProduct::updateProductQuantity($cart->getId(), $productId, $newQuantity);
                    } else {
                        CartProduct::deleteProduct($cart->getId(), $productId);
                    }
                }

                if ($action === 'add') {
                    if ($cartProduct) {
                        $newQuantity = $cartProduct->getQuantity() + 1;
                        CartProduct::updateProductQuantity($cart->getId(), $productId, $newQuantity);
                    } else {
                        CartProduct::add($cart->getId(), $productId, 1);
                    }
                }
            } elseif ($action === 'add') {
                Cart::create($userId);
                $cart = Cart::getOneByUserId($userId);
                CartProduct::add($cart->getId(), $productId, 1);
            }

            header("Location: /main");
        }
    }
}