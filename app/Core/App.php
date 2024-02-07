<?php

namespace Core;

use Core\Request\Request;
use Core\Service\Authentication\CookieAuthenticationService;
use Core\Service\LoggerService;
use Throwable;

class App
{
    private array $routes = [];

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
                $requestClass = $handler['request'] ?? Request::class; // иначе передается объект общего Request

                $authenticationService = new CookieAuthenticationService();
                $obj = new $class($authenticationService); //создаем объект контроллера

                $request = new $requestClass($_POST); //создаем объект класса Request

                try {
                    $obj->$method($request);
                } catch (Throwable $exception) {
                    LoggerService::error($exception);
//info метод
                    require_once './../View/500.php';
                }
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.php';
        }
    }

    public function get(string $route, string $class, string $method, string $requestClass = null)
    {
        $this->routes[$route]['GET'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function post(string $route, string $class, string $method, string $requestClass = null)
    {
        $this->routes[$route]['POST'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function put(string $route, string $class, string $method, string $requestClass = null)
    {
        $this->routes[$route]['PUT'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function delete(string $route, string $class, string $method, string $requestClass = null)
    {
        $this->routes[$route]['DELETE'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }
}
