<?php

namespace Resource;

use Model\CartProduct;
use Model\Product;

class CartProductResource
{
    public static function format (CartProduct $cartProduct): array
    {
        $productId        = $cartProduct->getProductId();
        $product          = Product::getOneById($productId);
        $productLineTotal = $cartProduct->getQuantity() * $product->getPrice();

        return [
            'id' => $productId,
            'info' => $product,
            'quantity' => $cartProduct->getQuantity(),
            'lineTotal' => $productLineTotal,
            'link' => $product->getLink(),
            'name' => $product->getName()
        ];
    }
}