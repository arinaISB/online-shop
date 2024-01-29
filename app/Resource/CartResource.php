<?php

namespace Resource;

use Model\Cart;
use Model\CartProduct;

class CartResource
{
    public static function format(Cart $cart): array
    {
        $cartProducts = CartProduct::getAllByCartId($cart->getId());

        $products = [];
        foreach ($cartProducts as $cartProduct)
        {
            $products[] = CartProductResource::format($cartProduct);
        }

        $totalPrice = 0;
        foreach ($products as $product)
        {
            $totalPrice += $product['lineTotal'];
        }

        return [
            'cart' => $cart,
            'products' => $products,
            'totalPrice' => $totalPrice,
        ];
    }
}