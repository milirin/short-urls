<?php

class Request { 
    public array $data = [];

    public function __construct()
    {
        
    }

    public function storeData(array $data)
    {
        $this->data = array_merge();
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function trimString(string $string, string $separator): string
    {
        $result = rtrim($string, $separator);
        $result = ltrim($result, $separator);
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