<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\ResponseFormatter;
use App\Services\RequestService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\MiddlewareInterface;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Contracts\SessionInterface;

readonly class OthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private SessionInterface         $session,
        private RequestService           $requestService,
        private ResponseFormatter        $responseFormatter
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $request->getAttribute("__route__");
        $permission = $route->getArgument("permission");
        $permissions = $this->session->get("permissions");
        if (in_array($permission, $permissions)) {
            return $handler->handle($request);
        }
        if ($this->requestService->isXhr($request)) {
            $response = $this->responseFactory->createResponse();
            return $this->responseFormatter->asJson($response->withStatus(403), 'لا يوجد لديك الصلاحيات المطلوبة للقيام بهذه العملية');
        }

        $this->session->put('error', 'لا يوجد لديك الصلاحيات المطلوبة للقيام بهذه العملية');
        $referer  = $this->requestService->getReferer($request);
        $Pattern = $route->getPattern();
        $goTo = $Pattern == $referer ? "/" : $referer;
        return $this->responseFactory->createResponse(302)->withHeader('Location', $goTo);
    }
}
