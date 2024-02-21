<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutOSAction extends Action
{
  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    $this->auth->logout();

    return $this->response->withHeader('Location', '/login')->withStatus(302);
  }
}
