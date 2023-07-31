<?php

use function DI\create;
use Storylog\Core\View;
use Storylog\Core\Config;
use Storylog\Core\Database;
use Psr\Container\ContainerInterface;

return [
    Config::class => create(Config::class)->constructor(
        require CONFIG_PATH . '/app.php'
    ),
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
    View::class => function(){
        return new View();
    }
];