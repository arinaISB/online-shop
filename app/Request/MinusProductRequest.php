<?php

namespace Request;

use Core\Request\Request;

class MinusProductRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        $productId = $this->getProductId();

        if (empty($productId))
        {
            $errors['remove_product'] =  "An error has occurred. Please fill out all fields.";
        }

        return $errors;
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }
}