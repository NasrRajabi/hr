<?php

declare(strict_types=1);

namespace App;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserProviderServiceInterface;


class Auth implements AuthInterface
{
    private ?array $user = null;

    public function __construct(
        private readonly UserProviderServiceInterface $userProvider,
        private readonly SessionInterface $session
    ) {
    }

    public function user(): ?array
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $userId = $this->session->get('user_id');

        if (!$userId) {
            return null;
        }

        $user = $this->userProvider->getById($userId);

        if (!$user) {
            return null;
        }

        $this->user = $user;

        return $this->user;
    }

    public function attemptLogin(array $credentials): bool
    {

        $user = $this->userProvider->getByCredentials($credentials);
        if ($user['rowCount'] === 0) {
            return false;
        }
        if (!$this->checkCredentials($user, $credentials) || !$this->checkIsActive($user)) {

            return false;
        }

        $this->logIn($user);

        return true;
    }

    public function checkCredentials(array $user, array $credentials): bool
    {
        return password_verify($credentials['password'], $user['result']->password);
    }
    public function changeCredentials(string $credentials): string
    {
        return password_hash($credentials, PASSWORD_DEFAULT);
    }
    public function checkIsActive(array $user): bool
    {
        return $user['result']->active;
    }

    public function logOut(): void
    {
        $this->session->forget('user_id');
        $this->session->forget('f_name');
        $this->session->forget('s_name');
        $this->session->forget('t_name');
        $this->session->forget('l_name');
        $this->session->forget('gender');
        $this->session->forget('religion');
        $this->session->forget('birthday');
        $this->session->forget('birthplace');
        $this->session->forget('nationality');
        $this->session->forget('national_id');
        $this->session->forget('passport_no');
        $this->session->forget('marital_status');
        $this->session->forget('disability');
        $this->session->forget('avatar');
        $this->session->forget('secret_key');
        $this->session->forget('active');
        $this->session->forget('lock');
        $this->session->forget('is_first_login');

        $this->session->forget('os_id');
        $this->session->forget('permissions');
        $this->session->forget('user_role');
        $this->session->forget('has_multi_oS');
        $this->session->regenerate();

        $this->user = null;
    }
    public function logOutOs(): void
    {
        $this->session->forget('os_id');
        $this->session->forget('permissions');
        $this->session->forget('user_role');
    }

    public function logIn(array $user): void
    {

        $this->session->regenerate();
        $this->session->put('user_id',  $user['result']->id);
        $this->session->put('f_name',  $user['result']->f_name);
        $this->session->put('s_name',  $user['result']->s_name);
        $this->session->put('t_name',  $user['result']->t_name);
        $this->session->put('l_name',  $user['result']->l_name);
        $this->session->put('gender',  $user['result']->gender);
        $this->session->put('religion',  $user['result']->religion);
        $this->session->put('birthday',  $user['result']->birthday);
        $this->session->put('birthplace',  $user['result']->birthplace);
        $this->session->put('nationality',  $user['result']->nationality);
        $this->session->put('national_id',  $user['result']->national_id);
        $this->session->put('passport_no',  $user['result']->passport_no);
        $this->session->put('marital_status',  $user['result']->marital_status);
        $this->session->put('disability',  $user['result']->disability);
        $this->session->put('avatar',  $user['result']->avatar);
        $this->session->put('secret_key',  $user['result']->secret_key);
        $this->session->put('active',  $user['result']->active);
        $this->session->put('lock',  $user['result']->lock);
        $this->session->put('is_first_login',  $user['result']->is_first_login);
        $this->user = $user;
    }

    public function loginOS($role_id, $os_id, $permissions, $hasMultiOS, $job_id): array {
        $permissions_list = $permissions['result'];
        if ($permissions['rowCount'] > 1) {
          $permissions_list = array_column($permissions['result'], 'permissions_key');
          $permissionsIds = array_column($permissions['result'], 'id');
        }
        $this->session->put("permissions", $permissions_list);
        $this->session->put("os_id", $os_id );
        $this->session->put("job_id", $job_id );
        $this->session->put("user_role", $role_id );
        $this->session->put("has_multi_oS", $hasMultiOS );

        return $permissionsIds;
    }
}
