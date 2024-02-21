<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;

class ViewLoginFirstAction extends Action
{

  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    return $this->view->render(
      $this->response,
      'login_first.twig',
    );
  }
}
