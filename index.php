<?php
require './core/Application.php';
require './controllers/User.php';

$app = new Application();

$app->router->get('/pages', function ()
{
    echo 'get pages';
});

$app->router->get('/users', [User::class, 'getAll']);

$app->router->get('/users/:id', function (int $id)
{
    echo 'user by id '.$id;
});

$app->router->get('/urls', function ()
{
    echo 'get urls';
});

$app->router->post('/users', function ()
{
    echo 'post users';
});

$app->run();
// TODO: сделать с id  /pages/:id
// $app->router->get('/users', [User::class, 'getAll']);