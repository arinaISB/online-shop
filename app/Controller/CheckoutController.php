<?php

namespace Controller;

class CheckoutController
{
    public function getPlaceOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header("Location: /login");
        } else {
            require_once './../View/place_order.php';
        }
    }
}