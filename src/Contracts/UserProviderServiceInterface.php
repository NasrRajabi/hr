<?php

declare(strict_types = 1);

namespace App\Contracts;

use App\DataObjects\RegisterUserData;

interface UserProviderServiceInterface
{
    public function getById(int $userId): array;

    public function getByCredentials(array $credentials): array;


}