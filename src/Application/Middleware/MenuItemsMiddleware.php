<?php

declare(strict_types = 1);

namespace App\Application\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class MenuItemsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig             $twig,
        private SessionInterface $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    { //dd($this->session->get('menuItems'));
        if ($menuItems = $this->session->get('menuItems') ) {
            $this->twig->getEnvironment()->addGlobal('menuItems', $menuItems);
        }

        return $handler->handle($request);
    }
}