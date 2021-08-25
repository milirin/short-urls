<?php
require './core/Application.php';
require './controllers/User.php';

$app = new Application();

$app->router->get('/pages', function ()
{
    echo 'get pages';
});

$app->router->get('/users', [User::class, 'getAll']);

$app->router->post('/users', [User::class, 'getAll']);

$app->router->get('/users/:id', function (int $id)
{
    echo 'user by id '.$id;
});

$app->router->get('/urls', function ()
{
    echo 'get urls';
});

$app->run();

//todo запихнуть в data в request params, метод post и get, php://input