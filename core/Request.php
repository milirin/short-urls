<?php

class Request { 
    public array $data = [];

    public function __construct()
    {
        
    }

    public function storeData(array $data)
    {
        $content = file_get_contents('php://input');
        $decoded_content = json_decode($content, TRUE);
        
        if (!is_array($decoded_content)) {
            $decoded_content = [];
        }

        $this->data = array_merge($data, $_POST, $decoded_content);
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