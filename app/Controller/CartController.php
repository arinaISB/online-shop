<?php

namespace Controller;

use Kivinus\MyCore\Service\Authentication\AuthenticationInterface;
use Exception;
use Exceptions\UserNotFoundExceptions;
use Model\Cart;
use Model\CartProduct;
use Request\DeleteProductRequest;
use Resource\CartResource;

class CartController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @throws Exception
     */
    public function getCartForm(): void
    {
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        try {
            $user= $this->authenticationService->getCurrentUser();
        } catch (UserNotFoundExceptions) {
            require_once './../View/500.php';
        }

        $userId = $user->getId();
        $cart = Cart::getOneByUserId($userId);

        if (empty($cart))
        {
            Cart::create($userId);
            $cart = Cart::getOneByUserId($userId);
        }

        $productsInCart = CartProduct::getAllByCartId($cart->getId());
        $viewData = CartResource::format($cart);

        require_once './../View/cart.php';
    }

    /**
     * @throws Exception
     */
    public function deleteProduct(DeleteProductRequest $request): void
    {
        if (!$this->authenticationService->check())
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors)) {
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

            $productId = $request->getProductId();
            CartProduct::deleteProduct($cart->getId(), $productId);

            header("Location: /cart");
        }
    }
}
