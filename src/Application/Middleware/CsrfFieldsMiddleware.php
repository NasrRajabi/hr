<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Views\Twig;

readonly class CsrfFieldsMiddleware implements Middleware
{
    public function __construct(private Twig $twig, private ContainerInterface $container)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $csrf = $this->container->get('csrf');
        // CSRF token name and value
        $csrfNameKey    = $csrf->getTokenNameKey();
        $csrfValueKey   = $csrf->getTokenValueKey();
        $csrfName       = $csrf->getTokenName();
        $csrfValue      = $csrf->getTokenValue();

        $fields = <<<CSRF_Fields
<input type="hidden" name="$csrfNameKey" value="$csrfName">
<input type="hidden" name="$csrfValueKey" value="$csrfValue">
CSRF_Fields;

        $this->twig->getEnvironment()->addGlobal('csrf', [
            'keys' => [
                'name'  => $csrfNameKey,
                'value' => $csrfValueKey
            ],
            'name'  => $csrfName,
            'value' => $csrfValue,
            'fields' => $fields
        ]);
        return $handler->handle($request);
    }
}
