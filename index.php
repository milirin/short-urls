<?php
require './core/Application.php';
require './database/Database.php';
require './controllers/UserController.php';

$app = new Application();

$app->router->get('/pages', function ()
{
    echo 'get pages';
});

$app->router->get('/users', [UserController::class, 'getAll']);

$app->router->get('/users/:id', [UserController::class, 'getById']);

$app->router->get('/users/:id/remove', [UserController::class, 'remove']);

$app->router->post('/users/create', [UserController::class, 'create']);

$app->router->get('/urls', function ()
{
    echo 'get urls';
});

$app->run();