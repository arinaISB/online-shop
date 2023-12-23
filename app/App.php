<?php

use Controller\MainController;
use Controller\UserController;

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistration'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registration'
            ]
        ],

        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registration'
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getProducts'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'logout'
            ]
        ]
    ];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        $obj = new Controller\UserController();//теперь обращаемся к классу с указанием namespace

        if (isset($this->routes[$requestUri])) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $routeMethods = $this->routes[$requestUri];

            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();
                $obj->$method($_POST);
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.php';
        }
    }
}
