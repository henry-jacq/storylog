<?php

use function DI\create;
use Storylog\Core\View;
use Storylog\Model\Blog;
use Storylog\Model\User;
use Storylog\Core\Config;
use Storylog\Model\Image;
use Storylog\Core\Database;
use Storylog\Services\BlogService;
use Psr\Container\ContainerInterface;

return [
    Config::class => create(Config::class)->constructor(
        require CONFIG_PATH . '/app.php'
    ),
    Image::class => function () {
        if (extension_loaded('gd')) {
            return new Image();
        }
        throw new \RuntimeException('gd extension not loaded');
    },
    PDO::class => function (ContainerInterface $container) {
        $config = $container->get(Config::class)->get('db');
        $pdo = new PDO(
            "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}", $config['user'], $config['pass'], [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
        return $pdo;
    },
    Database::class => function (ContainerInterface $container) {
        return new Database($container->get(PDO::class));
    },
    View::class => function(ContainerInterface $container){
        return new View($container->get(Config::class));
    },
    Blog::class => function (ContainerInterface $container) {
        return new Blog($container->get(Database::class));
    },
    User::class => function (ContainerInterface $container) {
        return new User($container->get(Database::class));
    },
    BlogService::class => function(ContainerInterface $container) {
        return new BlogService(
            $container->get(Blog::class),
            $container->get(Image::class)
        );
    }
];