<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Storylog\Controllers\AuthController;
use Storylog\Controllers\BlogController;
use Storylog\Controllers\HomeController;
use Storylog\Controllers\CategoryController;
use Storylog\Middleware\AuthenticateMiddleware;
use Storylog\Middleware\AuthMiddleware;
use Storylog\Middleware\AuthoriseMiddleware;

return function (App $app) {

    $app->group('/', function(RouteCollectorProxy $group) {
        $group->get('', [HomeController::class, 'index']);
        $group->get('profile/edit', [HomeController::class, 'edit_profile']);
        $group->get('profile/{username}', [HomeController::class, 'profile']);

        $group->get('blog/create', [BlogController::class, 'create']);
        $group->post('blog/create', [BlogController::class, 'publish']);
        $group->get('blog/edit/{slug}', [BlogController::class, 'edit']);
        $group->get('blog/{blogname}', [BlogController::class, 'index']);
        $group->get('files/{category}/{image}', [BlogController::class, 'files']);

        $group->get('category/{category}', [CategoryController::class, 'category']);
    })->add(AuthoriseMiddleware::class)->add(AuthenticateMiddleware::class);

    $app->group('/', function (RouteCollectorProxy $group) {
        $group->get('login', [AuthController::class, 'login']);
        $group->post('login', [AuthController::class, 'verifyLogin']);
        $group->get('register', [AuthController::class, 'register']);
        $group->post('register', [AuthController::class, 'createUser']);
        $group->get('forgot-password', [AuthController::class, 'forgotPassword']);
    })->add(AuthMiddleware::class);
    
    $app->get('/logout', [AuthController::class, 'logout']);
};