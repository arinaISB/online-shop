<?php

namespace Controller;
use Kivinus\MyCore\Service\Authentication\AuthenticationInterface;
use Exception;
use Exceptions\UserNotFoundExceptions;
use Model\Cart;
use Model\CartProduct;
use Request\MinusProductRequest;
use Request\PlusProductRequest;

class CartProductController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getAddProductForm(): void
    {
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        require_once './../View/main.php';
    }

    /**
     * @throws Exception
     */
    public function minusQuantity(MinusProductRequest $request): void
    {
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors))
        {
            $productId = $request->getProductId();

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

            header("Location: /main");
        }
    }

    public function plusQuantity(PlusProductRequest $request): void
    {
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors))
        {
            $productId = $request->getProductId();

            try {
                $user= $this->authenticationService->getCurrentUser();
            } catch (UserNotFoundExceptions) {
                require_once './../View/500.php';
            }

            $userId = $user->getId();
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