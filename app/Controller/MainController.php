<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Resource\CartResource;
use Service\AuthenticationInterface;

class MainController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
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

            $cartResource = CartResource::format($cart);
            $uniqueProductCount = $cartResource['uniqueProductCount'];
        }

        require_once './../View/main.php';
    }

    public function updateUniqueProductCount(): void
    {
        $userId = $this->authenticationService->getCurrentUser()->getId();
        $cart = Cart::getOneByUserId($userId);


        $cartResource = CartResource::format($cart);
        $updatedUniqueProductCount = $cartResource['uniqueProductCount'];

        echo $updatedUniqueProductCount;
    }
}