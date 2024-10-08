<?php

namespace App\Middleware;

use App\Entity\User;
use App\Core\Request;
use App\Core\Session;
use App\Services\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthoriseMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Session $session,
        private readonly Request $requestService,
        private readonly AuthService $authService,
        private readonly ResponseFactoryInterface $responseFactory
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $_SESSION['user'] = 1;
        if (is_null($this->session->get('user'))) {
            if ($request->getMethod() === 'GET' && !$this->requestService->isXhr($request)) {
                $this->session->put('_redirect', (string) $request->getUri());
                return $this->responseFactory
                    ->createResponse(302)
                    ->withHeader('Location', '/login');
            }
        } else {
            // Get the user by id
            $user = $this->entityManager->getRepository(User::class)
                ->find($this->session->get('user'));

            if ($user) {
                $request = $request->withAttribute('userData', $user);
            }
        }
        return $handler->handle($request);
    }
}
