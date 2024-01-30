<?php

namespace Request;

class EditQuantityProductRequest extends Request
{
    public function getProductId()
    {
        return $this->body['product_id'];
    }

    public function getAction()
    {
        return $this->body['action'];
    }

    public function validate(): array
    {
        $errors = [];

        $productId = $this->getProductId();

        if (empty($productId))
        {
            $errors['add_product'] =  "An error has occurred. Please fill out all fields.";
        }

        return $errors;
    }
}