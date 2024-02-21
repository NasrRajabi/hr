<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;


use App\Application\Actions\Action;
use App\Models\Menu\MenuModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Auth\LoginOSRequestValidator;
use App\Models\Auth\AuthModel;

//TODO_Aya: check the case of return to login from login_os --> it should not alowe return
class LoginOSAction extends Action
{
  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    //$this->recaptcha();

    $data = $this->requestValidatorFactory->make(LoginOSRequestValidator::class)->validate(
      $this->request->getParsedBody()
    );

    $permissionsIds = [];
    $user_os = AuthModel::getOs($this->session->get("user_id"));    
    $os = array_filter($user_os['result'], function ($obj) use($data){
      return $obj->os_id == $data["os_id"];
    });
    $os = array_values($os)[0];
    $permissions = AuthModel::getPermissions($os->role_id);
    $permissionsIds = $this->auth->loginOS($os->role_id, $os->os_id, $permissions, true, $os->job_id);
    
    $this->getMenu($permissionsIds);
    return $this->response->withHeader('Location', '/')->withStatus(302);
  }
  private function getMenu($permissionsIds) :void
  {

      $menuMenuItems = MenuModel::menuMenuItems( $permissionsIds );
      // dd($menuMenuItems );
      //$menuMenuItems = array_column($menuMenuItems, 'menuItems');
      $this->session->put("menuItems", $menuMenuItems['result']);

  }
}
