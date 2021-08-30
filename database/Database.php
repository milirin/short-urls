<?php

class Database { 
    public PDO $pdo;
    
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=mysql;dbname=short_urls', 'root', '123');
    }
}