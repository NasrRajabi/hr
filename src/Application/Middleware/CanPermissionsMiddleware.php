<?php

declare(strict_types = 1);

namespace App\Application\Middleware;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class CanPermissionsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Twig             $twig,
        private SessionInterface $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
       // dd($this->session->get('permissions'));
        if ($permissions = $this->session->get('permissions') ) {
            // Flip the array to convert values into keys and set values to true
            $outputArray = array_flip($permissions);
            // Set all values to true
            $outputArray = array_map(function () { return true; }, $outputArray);

            $this->twig->getEnvironment()->addGlobal('permissions', $outputArray);
        }

        return $handler->handle($request);
    }
}