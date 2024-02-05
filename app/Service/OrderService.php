<?php

namespace Service;

use Model\Cart;
use Model\CartProduct;
use Model\Model;
use Model\OrderedCart;
use Model\PlacedOrder;
use Model\User;
use Resource\CartProductResource;

class OrderService
{
    public function create(PlacedOrder $order, User $user): void
    {
        $pdo = Model::getPdo();
        $cart = Cart::getOneByUserId($user->getId());
        $cartProducts = CartProduct::getAllByCartId($cart->getId());
        $orderId = $order->getId();

        $pdo->beginTransaction();
        try {
            $order->save();
            foreach ($cartProducts as $productInCart)
            {
                $product = CartProductResource::format($productInCart);
                OrderedCart::addOrderedItems($orderId, $product['id'], $productInCart->getQuantity(), $product['lineTotal']);
            }
            CartProduct::deleteProductByCart($cart->getId());
            $pdo->commit();

        } catch (\Throwable $exception) {
            $pdo->rollBack();
        }
    }

}