<?php

namespace App;

use Exception;
use Throwable;

class Router
{
    /**
     * @var array $routes
     */
    protected $routes = [];

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * @param string $method
     * 
     * @return void
     */
    private function addRoute($route, $controller, $action, $method): void
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action];
    }

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * 
     * @return void
     */
    public function get($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * 
     * @return void
     */
    public function post($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * 
     * @return void
     */
    public function put($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * 
     * @return void
     */
    public function delete($route, $controller, $action): void
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    /**
     * Dispacth route action
     * 
     * @return void
     */
    public function dispatch(): void
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        try {
            if (! array_key_exists($uri, $this->routes[$method])) {
                throw new Exception("No route found for URI: $uri", 404);   
            }

            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action();
        } catch (Throwable $th) {
            include "Views/Errors/{$th->getCode()}.php";
        }
    }
}
