<?php

namespace App\Core;

use App\Interfaces\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class Request
{
    public function __construct(private readonly SessionInterface $session) {}

    public function getReferer(ServerRequestInterface $request): string
    {
        $referer = $request->getHeader('referer')[0] ?? '';

        if (!$referer) {
            return $this->session->get('previousUrl');
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);

        if ($refererHost !== $request->getUri()->getHost()) {
            $referer = $this->session->get('previousUrl');
        }

        return $referer;
    }

    public function isXhr(ServerRequestInterface $request): bool
    {
        return $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }

    public function getIpAddress(ServerRequestInterface $request): string
    {
        return $request->getServerParams()['REMOTE_ADDR'] ?? null;
    }

    public function getUserAgent(ServerRequestInterface $request): string
    {
        return $request->getHeaderLine('User-Agent') ?? null;
    }
}
