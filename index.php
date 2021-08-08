<?php
require './core/Application.php';
require './controllers/User.php';

$app = new Application();

$app->router->get('/pages', function ()
{
    echo 'get pages';
});

$app->router->get('/users', function ()
{
    echo 'get users';
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