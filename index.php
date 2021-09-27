<?php
require './core/Application.php';
require './database/Database.php';
require './models/Model.php';
require './controllers/UserController.php';
require './controllers/PostController.php';

$app = new Application();

$app->router->get('/pages', function ()
{
    echo 'get pages';
});

$app->router->get('/users', [UserController::class, 'getAll']);

$app->router->get('/users/:id', [UserController::class, 'getById']);

$app->router->delete('/users/:id', [UserController::class, 'remove']);

$app->router->patch('/users/:id', [UserController::class, 'update']);

$app->router->post('/users/create', [UserController::class, 'create']);

$app->router->get('/users/:id/posts', [UserController::class, 'getPosts']);

$app->router->get('/posts', [PostController::class, 'getAll']);

$app->router->get('/posts/:id', [PostController::class, 'get']);

$app->router->get('/urls', function ()
{
    echo 'get urls';
});

$app->run();