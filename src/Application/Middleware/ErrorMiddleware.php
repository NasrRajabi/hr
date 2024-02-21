<?php

declare(strict_types = 1);

namespace App\Application\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class ErrorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig             $twig,
        private SessionInterface $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        if ($error = $this->session->get('error')) {
            $this->session->forget('error');
            $this->twig->getEnvironment()->addGlobal('error', $error);
        }

        return $handler->handle($request);
    }
}