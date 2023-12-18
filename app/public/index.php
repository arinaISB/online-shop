<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registrate') {
    if ($requestMethod === 'GET') {
        require_once './html/registrate.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handler/registrate.php';
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './html/login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handler/login.php';
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        require_once './handler/main.php';
    }
} else {
    require_once './html/not_found.php';
}
