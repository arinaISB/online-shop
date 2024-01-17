<?php

namespace Request;

class Request
{
    private array $body;
    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}