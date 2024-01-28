<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
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

    public function addProduct(AddProductRequest $request): void
    {
        $result = $this->authenticationService->check();
        if (!$result)
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors))
        {
            $products = Product::getAll();
            $productId = $request->getProductId();
            $quantity = $request->getQuantity();

            $userId = $this->authenticationService->getCurrentUser()->getId();
            $cart = Cart::getCart($userId);

            if (!empty($cart)) {
                $cartProduct = CartProduct::getCartProduct($cart->getId(), $productId);

                if (empty($cartProduct)) {
                    CartProduct::addCartProducts($cart->getId(), $productId, $quantity);
                } else {
                    $currentQuantity = $cartProduct->getQuantity();
                    $newQuantity = $currentQuantity + $quantity;
                    CartProduct::updateProductQuantity($cart->getId(), $productId, $newQuantity);
                }
            } else {
                Cart::createCart($userId);
                $cart = Cart::getCart($userId);
                CartProduct::addCartProducts($cart->getId(), $productId, $quantity);
            }

            header("Location: /main");
            require_once './../View/main.php';
        }
    }
}