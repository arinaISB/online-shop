<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Request\MinusProductRequest;
use Request\PlusProductRequest;
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

    public function minusQuantity(MinusProductRequest $request): void
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

            if (!empty($cart)) {
                $cartProduct = CartProduct::get($cart->getId(), $productId);

                if (!empty($cartProduct)) {
                    $currentQuantity = $cartProduct->getQuantity();
                    if ($currentQuantity > 1) {
                        $newQuantity = $currentQuantity - 1;
                        CartProduct::updateProductQuantity($cart->getId(), $productId, $newQuantity);
                    } else {
                        CartProduct::deleteProduct($cart->getId(), $productId);
                    }
                }
            }

            header("Location: /main");
        }
    }

    public function plusQuantity(PlusProductRequest $request): void
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

            if (!empty($cart)) {
                $cartProduct = CartProduct::get($cart->getId(), $productId);

                if (empty($cartProduct)) {
                    CartProduct::add($cart->getId(), $productId, 1);
                } else {
                    $currentQuantity = $cartProduct->getQuantity();
                    $newQuantity = $currentQuantity + 1;
                    CartProduct::updateProductQuantity($cart->getId(), $productId, $newQuantity);
                }
            } else {
                Cart::create($userId);
                $cart = Cart::getOneByUserId($userId);
                CartProduct::add($cart->getId(), $productId, 1);
            }

            header("Location: /main");
        }
    }
}