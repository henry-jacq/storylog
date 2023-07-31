<?php

return [
    'app' => [
        'name' => $_ENV['APP_NAME'],
        'host' => $_ENV['APP_URL'] ?? 'http://localhost',
        'version' => $_ENV['APP_VERSION'] ?? '1.0'
    ],
    'db' => [
        'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
    ],
    'mailer' => [
        'dsn' => $_ENV['MAILER_DSN'],
        'from' => $_ENV['MAILER_FROM']
    ]
];
