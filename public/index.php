<?php

use Storylog\Controllers\AuthController;
use Storylog\Controllers\CategoryController;
use Storylog\Controllers\HomeController;
use Storylog\Core\Application;

include __DIR__ . '/../bootstrap.php';


$app = new Application(APP_PATH, $config);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$app->router->get('/', [HomeController::class, 'home']);
$app->router->get('/profile/{username}', [HomeController::class, 'profile']);
$app->router->get('/blog/{blogname}', [HomeController::class, 'blog']);
$app->router->get('/category/{categoryname}', [CategoryController::class, 'category']);

$app->run();