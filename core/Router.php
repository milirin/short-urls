<?php
require './core/Request.php';
require './core/Response.php';

class Router
{
    private Request $request;
    private Response $response;
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
        $this->response = new Response;
    }

    public function storeRoute(string $method, string $endPoint, callable|array $callback)
    {
        $endPoint = ltrim($endPoint, '/');
        $endPoint = rtrim($endPoint, '/');
        $params = [];
        $explEndPoint = explode('/', $endPoint);
        $uriChunks = $this->request->uriChunks();

        foreach ($explEndPoint as $key => $chunk) {
            if (str_starts_with($chunk, ':')) {
                $chunk = str_replace(':', '', $chunk);
                $params[$chunk] = $uriChunks[$key];
            }
        }

        $this->routes[$method][$endPoint] = ['callback' => $callback, 'params' => $params];
    }

    public function get(string $endPoint, callable|array $callback)
    {
        $this->storeRoute("get", $endPoint, $callback);
    }

    public function post(string $endPoint, callable|array $callback)
    {
        $this->storeRoute("post", $endPoint, $callback);
    }

    public function put(string $endPoint, callable|array $callback)
    {
        $this->storeRoute("put", $endPoint, $callback);
    }

    public function patch(string $endPoint, callable|array $callback)
    {
        $this->storeRoute("patch", $endPoint, $callback);
    }

    public function delete(string $endPoint, callable|array $callback)
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
            if (is_callable($route['callback'])) {
                call_user_func_array($route['callback'], $route['params']);
            } else {
                $object = new $route['callback'][0];
                $method = $route['callback'][1];
                if (method_exists($object, $method)) {
                    $this->request->storeData($route['params']);
                    $object->$method($this->request, $this->response);
                } else {
                    header("HTTP/1.1 404 Page Not Found");
                }
            }
        } else {
            header("HTTP/1.1 404 Page Not Found");
        }
    }
}
