<?php

declare(strict_types=1);

namespace App\RequestValidators\Agreements;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

use App\Models\AttendanceAgreements\AgreementModel;


class AgreementRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['name']);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
        $v->labels(array(
            'name' => 'اسم الاتفاقية ',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
