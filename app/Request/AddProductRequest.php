<?php

namespace Request;

class AddProductRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        $productId = $this->getProductId();
        $quantity = $this->getQuantity();

        if (empty($productId))
        {
            $errors['add_product'] =  "An error has occurred. Please fill out all fields.";
        } elseif (empty($quantity) || $quantity < 1) {
            $errors['quantity'] = "Enter the correct number of products";
        }

        return $errors;
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