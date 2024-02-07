<?php

namespace Request;

use Core\Request\Request;

class DeleteProductRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (empty($this->body['product_id']))
        {
            $errors['delete'] = 'Enter the correct product';
        }
        return $errors;
    }

    public function getProductId(): int
    {
        return $this->body['product_id'];
    }
}