<?php
require './core/Router.php';

class Application {
    public Router $router;

    public function __construct()
    {
        $this->setHeaders();
        $this->router = new Router;
    }

    public function run(): void
    {
        $this->router->resolve();
    }

    private function setHeaders(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
}