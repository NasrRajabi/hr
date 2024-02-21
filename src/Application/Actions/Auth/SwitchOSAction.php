<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class SwitchOSAction extends Action
{
  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    $this->auth->logOutOS();

    return $this->response->withHeader('Location', '/login_os')->withStatus(302);
  }
}
