<?php

use Controller\CartController;
use Controller\CartProductController;
use Controller\MainController;
use Controller\PlaceOrderController;
use Controller\UserController;
use Request\RegistrationRequest;

require_once './../Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

$app = new App();

$app->get('/registration', UserController::class, 'getRegistration');
$app->get('/login', UserController::class, 'getLogin');
$app->get('/main', MainController::class, 'getProducts');
$app->get('/add-product', CartProductController::class, 'getAddProductForm');
$app->get('/placeOrder', PlaceOrderController::class, 'getPlaceOrderForm');
$app->get('/cart', CartController::class, 'getCartForm');

$app->post('/registration', UserController::class, 'registration', RegistrationRequest::class);
$app->post('/login', UserController::class, 'login');
$app->post('/logout', UserController::class, 'logout');
$app->post('/add-product', CartProductController::class, 'addProduct');
$app->post('/delete-product', CartController::class, 'deleteProduct');
$app->post('/placeOrder', PlaceOrderController::class, 'placeOrderForm');

$app->run();