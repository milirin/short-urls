<?php
require './core/Application.php';
require './controllers/User.php';

$app = new Application();

$app->router->get('/users', function (int $num1, int $num2)
{
    echo 'number1 - '.$num1.' number2 - '.$num2;
});

$app->router->get('/urls', function (int $num1, int $num2)
{
    echo 'gjgfgfgf - '.$num1.' gfgfgfgfgfg - '.$num2;
});

$app->router->post('/users', function (int $num1, int $num2)
{
    echo '111111 - '.$num1.' 1111111 - '.$num2;
});

// TODO: сделать чтобы определенная функция запускалась на определенной странице 
// $app->router->get('/users', [User::class, 'getAll']);