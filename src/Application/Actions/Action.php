<?php

declare(strict_types=1);

namespace App\Application\Actions;

use PDO;
use Slim\Views\Twig;
use App\ResponseFormatter;
use Psr\Log\LoggerInterface;
use App\Contracts\AuthInterface;
use App\Contracts\LookupsInterface;
use App\Contracts\SessionInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpBadRequestException;
use App\Contracts\RequestValidatorFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\DomainException\DomainRecordNotFoundException;

abstract class Action
{

    protected Request $request;

    protected Response $response;

    protected array $args;





    public function __construct( protected readonly LoggerInterface $logger,
                                 protected readonly Twig $view,
                                 protected readonly RequestValidatorFactoryInterface $requestValidatorFactory,
                                 protected readonly SessionInterface $session,
                                 protected readonly AuthInterface $auth,
                                 protected readonly LookupsInterface $lookups,
                                 protected readonly ResponseFormatter $responseFormatter)
    {}

    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     */
    protected function getFormData()
    {
        return $this->request->getParsedBody();
    }

    /**
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param array|object|null $data
     */
    protected function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }


    protected function redirect(string $route): Response
    {
        return $this->response
            ->withHeader('Location', $route)
            ->withStatus(302);
    }

    protected function msgError(string $error) : void
    {
        $this->session->put('error',$error);
    }
    protected function msgSuccess(string $success) : void
    {
        $this->session->put('success',$success);
    }
}
