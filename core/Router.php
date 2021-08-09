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
        $params = [];
        $explEndPoint = explode('/', $endPoint);
        $uriChunks = $this->request->uriChunks();

        foreach ($explEndPoint as $key => $chunk) {
            if (str_starts_with($chunk, ':')) {
                $params[] = $uriChunks[$key];
            }
        }

        $this->routes[$method][$endPoint] = ['callback' => $callback, 'params' => $params];
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
        $method = $this->request->method();
        $methodRoutes = $this->routes[$method];
        $route = [];

        foreach ($methodRoutes as $key => $routeValue) {
            $explRoute = explode('/', $key);
            if ($explRoute[0] === $this->request->uriChunks()[0] && count($explRoute) === count($this->request->uriChunks())) {
                $route = $routeValue;
                break;
            }
        }

        if (count($route)) {
            call_user_func_array($route['callback'], $route['params']);
        } else {
            header("HTTP/1.1 404 Page Not Found");
        }
    }
}
