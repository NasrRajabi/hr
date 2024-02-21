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

readonly class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private SessionInterface         $session,
        private AuthInterface            $auth
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($user = $this->auth->user()) {
           
            if (!$this->session->get('is_first_login')) {
                if ($this->session->get('os_id') !== null) {

                    return $handler->handle($request->withAttribute('user', $user));
                }
                return $this->responseFactory->createResponse(302)->withHeader('Location', '/login_os');
            }
            return $this->responseFactory->createResponse(302)->withHeader('Location', '/login_first');
        }

        return $this->responseFactory->createResponse(302)->withHeader('Location', '/login');
    }
}
