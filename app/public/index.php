<?php

require_once './../Controller/UserController.php';
require_once './../Controller/MainController.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$userController = new UserController();
$mainController = new MainController();

if ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        $userController->getRegistration();
    } elseif ($requestMethod === 'POST') {
        $userController->registration();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        $userController->getLogin();
    } elseif ($requestMethod === 'POST') {
        $userController->Login();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        $mainController->getProducts();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/logout') {
    if ($requestMethod === 'GET') {
        $userController->getLogout();
    } elseif ($requestMethod === 'POST') {
        $userController->logout();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} else {
    require_once './../View/not_found.php';
}
