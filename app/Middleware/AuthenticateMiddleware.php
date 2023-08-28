<?php

namespace Storylog\Middleware;

use Storylog\Model\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthenticateMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly User $user)
    {
    }
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!empty($_SESSION['user'])) {
            $user = $this->user->getUser();
            $request = $request->withAttribute('userData', $user);
        }
        
        return $handler->handle($request);
    }
}