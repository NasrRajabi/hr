<?php

declare(strict_types = 1);

namespace App\Application\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class SuccessMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig             $twig,
        private SessionInterface $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($success = $this->session->get('success')) {
            $this->session->forget('success');
            $this->twig->getEnvironment()->addGlobal('success', $success);
        }

        return $handler->handle($request);
    }
}