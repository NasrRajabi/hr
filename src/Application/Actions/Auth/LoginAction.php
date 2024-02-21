<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;


use App\Application\Actions\Action;
use App\Exception\ValidationException;
use App\Models\Menu\MenuModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Auth\AuthRequestValidator;
use App\Models\Auth\AuthModel;


class LoginAction extends Action
{

  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    //$this->recaptcha();

    $data = $this->requestValidatorFactory->make(AuthRequestValidator::class)->validate(
      $this->request->getParsedBody()
    );

    if (!$this->auth->attemptLogin($data)) {
      throw new ValidationException(['password' => ['لقد أدخلت رقم وظيفي أو كلمة مرور غير صالحة أو حسابك غير فعال']]);
    }

    //TODO Asem Yamak:  check if is lock 10 time

     


    $permissionsIds = [];
    // Check user job (os_id), if has multiple (os_id) then, redirect to os window, else retrive the user Permissions
    $user_os = AuthModel::getOs($this->session->get("user_id"));
    if ($user_os['status'] == true && $user_os['rowCount']  > 0) {
      if($user_os['rowCount'] === 1) {        
        $permissions = AuthModel::getPermissions($user_os['result']->role_id );
        $permissionsIds = $this->auth->loginOS($user_os['result']->role_id, $user_os['result']->os_id, $permissions, false, $user_os['result']->job_id);
        $this->getMenu($permissionsIds);
        return $this->response->withHeader('Location', '/')->withStatus(302);
      } else {
        return $this->response->withHeader('Location', '/login_os')->withStatus(302);
      }
    }
  }

  private function recaptcha(): void
  {

    try {
      // Build POST request:
      $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
      $recaptcha_secret = '6Lc3zPsgAAAAAKYA3N-nfjHHcpA5LBLvzRp6mtXp';
      $data = $this->request->getParsedBody();
      $recaptcha_response = $data['Re_Token'];

      // Initialize a CURL session.
      $ch = curl_init();
      // Return Page contents.
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // Grab URL and pass it to the variable
      curl_setopt($ch, CURLOPT_URL, $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

      $result = curl_exec($ch);

      $recaptcha = json_decode($result);

      if ($recaptcha->success == true) {
        // Take action based on the score returned:
        if ($recaptcha->score >= 0.9) {
          return;
        } else {
          throw new ValidationException(['password' => ['recaptcha warning']]);
        }
      } else { // there is an error /
        ///  timeout-or-duplicate meaning you are submit the  form
        throw new ValidationException(['password' => ['recaptcha timeout']]);
      }
    } catch (\Exception $ex) {
      //throw new ValidationException([$ex->getMessage()]);
      error_log($ex->getMessage());
      throw new ValidationException(['password' => ['recaptcha error']]);
    }
  }

    private function getMenu($permissionsIds) :void
    {

        $menuMenuItems = MenuModel::menuMenuItems( $permissionsIds );
       // dd($menuMenuItems );
        //$menuMenuItems = array_column($menuMenuItems, 'menuItems');
        $this->session->put("menuItems", $menuMenuItems['result']);

    }


}
