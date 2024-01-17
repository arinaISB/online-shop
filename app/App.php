<?php

use Controller\CartController;
use Controller\CartProductController;
use Controller\MainController;
use Controller\PlaceOrderController;
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
                'method' => 'login'
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getProducts'
            ]
        ],
        '/logout' => [
            'POST' => [
                'class' => UserController::class,
                'method' => 'logout'
            ]
        ],

        '/add-product' => [
            'GET' => [
                'class' => CartProductController::class,
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => CartProductController::class,
                'method' => 'addProduct'
            ]
        ],

        '/delete-product' => [
            'POST' => [
                'class' => CartController::class,
                'method' => 'deleteProduct'
            ]
        ],

        '/placeOrder' => [
            'GET' => [
                'class' => PlaceOrderController::class,
                'method' => 'getPlaceOrderForm'
            ],
            'POST' => [
                'class' => PlaceOrderController::class,
                'method' => 'placeOrderForm'
            ]
        ],

        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCartForm'
            ]
        ]
    ];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$requestUri])) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $routeMethods = $this->routes[$requestUri];

            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();

                $request = new Request\Request($_POST);
                $obj->$method($request);
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.php';
        }
    }
}
