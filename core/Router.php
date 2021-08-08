<?php
require './core/Request.php';

class Router
{
    private Request $request;
    private array $routes = [
        "get" => [],
        "post" => [],
        "put" => [],
        "patch" => [],
        "delete" => []
    ];

    public function __construct()
    {
        $this->request = new Request;
    }

    public function storeRoute(string $method, string $endPoint, callable $callback)
    {
        $endPoint = ltrim($endPoint, '/');
        $endPoint = rtrim($endPoint, '/');
        $this->routes[$method][$endPoint]['callback'] = $callback;
    }

    public function get(string $endPoint, callable $callback)
    {
        $this->storeRoute("get", $endPoint, $callback);
    }

    public function post(string $endPoint, callable $callback)
    {
        $this->storeRoute("post", $endPoint, $callback);
    }

    public function put(string $endPoint, callable $callback)
    {
        $this->storeRoute("put", $endPoint, $callback);
    }

    public function patch(string $endPoint, callable $callback)
    {
        $this->storeRoute("patch", $endPoint, $callback);
    }

    public function delete(string $endPoint, callable $callback)
    {
        $this->storeRoute("delete", $endPoint, $callback);
    }

    public function resolve(): void
    {
        $uri = $this->request->uri();
        $method = $this->request->method();
        if (array_key_exists($uri, $this->routes[$method])) {
            call_user_func($this->routes[$method][$uri]['callback']);
        } else {
            header("HTTP/1.1 404 Page Not Found");
        }
    }
}
