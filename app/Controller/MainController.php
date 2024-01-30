<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Service\AuthenticationService;

class MainController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getProducts(): void
    {
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        $products = Product::getAll();

        if (empty($products))
        {
            echo "No products";
            exit;
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $cart = Cart::getOneByUserId($userId);
        $quantitiesOfEachProductInTheCart = [];

        if (!empty($cart)) {
            $cartProducts = CartProduct::getAllByCartId($cart->getId());

            foreach ($cartProducts as $cartProduct) {
                $productId = $cartProduct->getProductId();
                $quantity = $cartProduct->getQuantity();
                $quantitiesOfEachProductInTheCart[$productId] = $quantity;
            }
        }

        require_once './../View/main.php';
    }
}