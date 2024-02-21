<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;


use App\Models\Auth\AuthModel;
use App\Models\Menu\MenuModel;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Auth\LoginOSRequestValidator;
use App\RequestValidators\Auth\LoginFirstRequestValidator;


class LoginFirstAction extends Action
{
  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    //$this->recaptcha();

    $data = $this->requestValidatorFactory->make(LoginFirstRequestValidator::class)->validate(
      $this->request->getParsedBody()
    );

    AuthModel::updateFirstLogin($this->session->get('user_id'), $this->auth->changeCredentials($data['new_password']));
    $this->session->put('is_first_login', false);
    
    return $this->response->withHeader('Location', '/login')->withStatus(302);
  }
}
