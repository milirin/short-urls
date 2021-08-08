<?php
require './core/Request.php';

class Router
{
    private Request $request;

    public function __construct()
    {
        $this->request = new Request;
    }

    public function get(string $endPoint, callable $callback)
    {
        if ($this->request->method() == 'get') {
            if ($endPoint == $this->request->uri()) {
                call_user_func($callback, 1, 2);
                echo $endPoint;
            }
        }
    }

    public function post(string $endPoint, callable $callback)
    {
        if ($this->request->method() == 'post') {
            if ($endPoint == $this->request->uri()) {
                call_user_func($callback, 1, 2);
                echo $endPoint;
            }
        }
    }
}
