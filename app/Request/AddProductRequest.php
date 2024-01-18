<?php

namespace Request;

class AddProductRequest extends Request
{
    public function validateData()
    {
        $productId = $this->getProductId();
        $quantity = $this->getQuantity();

        if (empty($productId) || empty($quantity) || $quantity < 1)
        {
            echo "An error has occurred. Please fill out all fields.";
            exit;
        }
        return true;
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }

    public function getQuantity()
    {
        return $this->body['quantity'];
    }

}