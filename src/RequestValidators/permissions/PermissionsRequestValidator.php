<?php
declare(strict_types=1);
namespace App\RequestValidators\Permissions;

use Valitron\Validator;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class PermissionsRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);
        $v->rule('required', ['id', 'key', 'group_name']);
        $v->rule('integer', ['id']);       

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}