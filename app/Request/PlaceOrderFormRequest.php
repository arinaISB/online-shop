<?php

namespace Request;

class PlaceOrderFormRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        if (empty($this->body)) {
            $errors[] = 'Error: Empty body';
        }

        return $errors;
    }

    public function getEmail(): string
    {
        return $this->body['checkout-email'];
    }

    public function getPhone(): string
    {
        return $this->body['checkout-phone'];
    }

    public function getName(): string
    {
        return $this->body['checkout-name'];
    }

    public function getAddress(): string
    {
        return $this->body['checkout-address'];
    }

    public function getCity(): string
    {
        return $this->body['checkout-city'];
    }

    public function getCountry(): string
    {
        return $this->body['checkout-country'];
    }

    public function getPostal(): string
    {
        return $this->body['checkout-postal'];
    }
}