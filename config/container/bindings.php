<?php

use Slim\App;
use function DI\create;
use Storylog\Core\View;
use Storylog\Model\Blog;
use Storylog\Model\User;
use Storylog\Core\Config;
use Storylog\Model\Image;
use Storylog\Core\Session;
use Storylog\Core\Database;
use Slim\Factory\AppFactory;
use Storylog\Services\BlogService;
use Psr\Container\ContainerInterface;
use Storylog\Interfaces\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Storylog\Interfaces\AuthInterface;
use Storylog\Services\HashService;
use Storylog\Services\RequestService;

return [
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        $middleware = require CONFIG_PATH . '/middleware.php';
        $router     = require CONFIG_PATH . '/routes/web.php';

        $app = AppFactory::create();

        $router($app);

        $middleware($app);

        return $app;
    },
    Config::class => create(Config::class)->constructor(
        require CONFIG_PATH . '/app.php'
    ),
    HashService::class => function() {
        return new HashService();
    },
    Image::class => function () {
        if (extension_loaded('gd')) {
            return new Image();
        }
        throw new \RuntimeException('gd extension not loaded');
    },
    Database::class => function (ContainerInterface $container) {
        $config = $container->get(Config::class)->get('db');
        $pdo = new \PDO(
            "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
            $config['user'],
            $config['pass'],
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
        return Database::getConnection($pdo);
    },
    View::class => function(ContainerInterface $container){
        return new View($container->get(Config::class));
    },
    SessionInterface::class => function (ContainerInterface $container) {
        return new Session($container->get(Config::class));
    },
    User::class => function (ContainerInterface $container) {
        return new User(
            $container->get(Database::class),
            $container->get(Session::class)
        );
    },
    Blog::class => function (ContainerInterface $container) {
        return new Blog(
            $container->get(User::class),
            $container->get(Database::class)
        );
    },
    BlogService::class => function(ContainerInterface $container) {
        return new BlogService(
            $container->get(Blog::class),
            $container->get(Image::class)
        );
    },
    ResponseFactoryInterface::class => fn(App $app) => $app->getResponseFactory(),
    AuthInterface::class => fn(ContainerInterface $container) => $container->get(Auth::class),
    RequestService::class => function(ContainerInterface $container) {
        return new RequestService($container->get(SessionInterface::class));
    },
];