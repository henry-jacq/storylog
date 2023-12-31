<?php

use Slim\App;
use Storylog\Core\Config;
use Storylog\Middleware\AuthenticateMiddleware;
use Storylog\Middleware\SessionStartMiddleware;
use Storylog\Middleware\ValidationErrorMiddleware;

return function (App $app) {

    $container = $app->getContainer();
    $config = $container->get(Config::class);
    
    $app->add(AuthenticateMiddleware::class);
    // $app->add(ValidationExceptionMiddleware::class);
    $app->add(ValidationErrorMiddleware::class);
    // $app->add(OldFormDataMiddleware::class);
    $app->add(SessionStartMiddleware::class);
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware(
        (bool) $config->get('app.display_error_details'),
        (bool) $config->get('app.log_errors'),
        (bool) $config->get('app.log_error_details')
    );
};