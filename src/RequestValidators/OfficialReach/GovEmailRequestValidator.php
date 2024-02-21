<?php

declare(strict_types=1);

namespace App\RequestValidators\OfficialReach;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

use App\Models\AttendanceAgreements\AgreementModel;


class GovEmailRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['email']);
        $v->rule('email', ['email']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
        $v->labels(array(
            'email' => 'البريد الالكتروني الحكومي ',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
