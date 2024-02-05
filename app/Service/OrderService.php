<?php

namespace Service;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Model\User;
use Resource\CartProductResource;

class OrderService
{
    public function create(PlacedOrder $order, User $user): void
    {
        $order->save();
        $cart = Cart::getOneByUserId($user->getId());
        $cartProducts = CartProduct::getAllByCartId($cart->getId());
        $orderId = $order->getId();

        foreach ($cartProducts as $productInCart)
        {
            $product = CartProductResource::format($productInCart);
            OrderedCart::addOrderedItems($orderId, $product['id'], $productInCart->getQuantity(), $product['lineTotal']);
        }
        CartProduct::deleteProductByCart($cart->getId());
    }

}