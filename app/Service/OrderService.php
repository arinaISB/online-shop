<?php

namespace Service;

use Model\Cart;
use Model\CartProduct;
use Model\OrderedCart;
use Model\PlacedOrder;
use Resource\CartProductResource;

class OrderService
{
    public function create(string $email, string $phone, string $userName, string $address, string $city, string $country, string $postal, float $totalPrice, Cart $cart): void
    {
        $placedOrderId = PlacedOrder::addAndGetId($totalPrice, $email, $phone, $userName, $address, $city, $country, $postal);

        $cartProducts = CartProduct::getAllByCartId($cart->getId());

        foreach ($cartProducts as $productInCart)
        {
            $product = CartProductResource::format($productInCart);
            OrderedCart::addOrderedItems($placedOrderId, $product['id'], $productInCart->getQuantity(), $product['lineTotal']);
            CartProduct::deleteProduct($cart->getId(), $product['id']);
        }
    }
}