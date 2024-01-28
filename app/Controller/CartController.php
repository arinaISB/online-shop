<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Request\DeleteProductRequest;
use Resource\CartResource;
use Service\AuthenticationService;


class CartController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getCartForm(): void
    {
        $result = $this->authenticationService->check();

        if (!$result)
        {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();
        $cart = Cart::getCart($userId);
        $productsInCart = CartProduct::getAllByCartId($cart->getId());

        $errors = $this->check($userId, $cart, $productsInCart);

        if (!empty($errors))
        {
            require_once './../View/cart.php';
            exit;
        }

        $viewData = CartResource::format($cart);
        require_once './../View/cart.php';
    }

    public function deleteProduct(DeleteProductRequest $request): void
    {
        $result = $this->authenticationService->check();

        if (!$result) {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors)) {
            $userId = $this->authenticationService->getCurrentUser()->getId();
            $cart = Cart::getCart($userId);
            $productId = $request->getProductId();
            CartProduct::deleteProduct($cart->getId(), $productId);

            header("Location: /cart");
        }
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
}
