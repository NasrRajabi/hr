<?php

declare(strict_types = 1);

namespace App\Application\Middleware;

use App\Contracts\LookupsInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

readonly class LookupMiddleware implements MiddlewareInterface
{
    
    public function __construct(
        private Twig             $twig,
        private LookupsInterface $lookup
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
     
        $this->twig->getEnvironment()->addGlobal('lookups',$this->lookup->get() );

        return $handler->handle($request);
    }
}