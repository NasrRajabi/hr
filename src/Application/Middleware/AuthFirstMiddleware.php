<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Contracts\AuthInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Contracts\SessionInterface;

readonly class AuthFirstMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private SessionInterface         $session,
        private AuthInterface            $auth
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        if (!$this->session->get('is_first_login')) {
            return $this->responseFactory->createResponse(302)->withHeader('Location', '/');
        }



        return $handler->handle($request);
    }
}
