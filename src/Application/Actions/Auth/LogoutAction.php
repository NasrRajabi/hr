<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;


use App\Application\Actions\Action;
use App\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Auth\AuthRequestValidator;

class LogoutAction extends Action
{

  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    $this->auth->logOut();

    return $this->response->withHeader('Location', '/login')->withStatus(302);
  }
}
