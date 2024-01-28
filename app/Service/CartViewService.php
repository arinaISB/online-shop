<?php

namespace Service;

use Model\Product;

class CartViewService
{
    public static function viewProductsInCart($productsInCart): array
    {
        $result = [
            'products' => [],
            'totalPrice' => CartViewService::calculateTotalPrice($productsInCart)
        ];

        foreach ($productsInCart as $productInCart) {
            $productId = $productInCart->getProductId();
            $productInfo = Product::getProductInfo($productId);
            $productLineTotal = $productInCart->getQuantity() * $productInfo->getPrice();

            $productData = [
                'id' => $productId,
                'info' => $productInfo,
                'quantity' => $productInCart->getQuantity(),
                'lineTotal' => $productLineTotal,
                'link' => $productInfo->getLink(),
                'name' => $productInfo->getName()
            ];

            $result['products'][] = $productData;
        }

        return $result;
    }

    public static function calculateTotalPrice($productsInCart): float|int
    {
        $totalPrice = 0;

        foreach ($productsInCart as $productInCart) {
            $productId = $productInCart->getProductId();
            $productInfo = Product::getProductInfo($productId);
            $productLineTotal = $productInCart->getQuantity() * $productInfo->getPrice();
            $totalPrice += $productLineTotal;
        }

        return $totalPrice;
    }
}