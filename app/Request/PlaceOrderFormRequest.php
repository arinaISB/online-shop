<?php

namespace Request;

class PlaceOrderFormRequest extends Request
{
    public function validate(): array
    {
        $errors = [];

        if (empty($this->getEmail()))
        {
            $errors['checkout-email'] = 'Error: Empty body';
        } elseif (empty($this->getPhone()))
        {
            $errors['checkout-phone'] = 'Error: Empty body';
        } elseif (empty($this->getName()))
        {
            $errors['checkout-name'] = 'Error: Empty body';
        } elseif (empty($this->getAddress()))
        {
            $errors['checkout-address'] = 'Error: Empty body';
        } elseif (empty($this->getCity()))
        {
            $errors['checkout-city'] = 'Error: Empty body';
        } elseif (empty($this->getCountry()))
        {
            $errors['checkout-country'] = 'Error: Empty body';
        } elseif (empty($this->getPostal()))
        {
            $errors['checkout-postal'] = 'Error: Empty body';
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