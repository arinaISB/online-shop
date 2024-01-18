<?php

namespace Request;

class DeleteProductRequest extends Request
{
    public function validate()
    {
        session_start();
        return isset($_SESSION['user_id']) && ($this->body['product_id']);
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }
}