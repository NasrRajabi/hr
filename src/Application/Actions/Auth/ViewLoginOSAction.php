<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Employee\EmployeeOSModel;

class ViewLoginOSAction extends Action
{

  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    // Get current user positions
    $os = EmployeeOSModel::getCurrentOSEmployeeByEmpId((int)$this->session->get("user_id"));

    return $this->view->render(
      $this->response,
      'login_os.twig',
      ['os' => $os['result'] ],
    );
  }
}
