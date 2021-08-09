<?php

class Request { 
    public function __construct()
    {
        
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function trimString(string $string, string $separator): string
    {
        $result = rtrim($string, $separator);
        $result = ltrim($string, $separator);
        return $result;
    }

    public function uri(): string 
    {
        $uri = $this->trimString($_SERVER['REQUEST_URI'], '/');
        return $uri;
    }   

    public function uriChunks(): array
    {
        $uri = $this->trimString($_SERVER['REQUEST_URI'], '/');
        return explode('/', $uri);
    }
}