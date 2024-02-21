<?php

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\DataObjects\RegisterUserData;
use App\Entity\User;
use App\Models\Auth\AuthModel;
use Doctrine\ORM\EntityManager;

class UserProviderService implements UserProviderServiceInterface
{
    public function __construct()
    {
    }

    public function getById(int $userId): array
    {
        return AuthModel::find($userId);
    }

    public function getByCredentials(array $credentials): array
    {
        return  AuthModel::findOneByEmployeeNo($credentials['employee_no']);
    }

}