<?php

class Request { 
    public function __construct()
    {
        
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function uri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = rtrim($uri, '/');
        $uri = ltrim($uri, '/');
        return $uri;
    }
}