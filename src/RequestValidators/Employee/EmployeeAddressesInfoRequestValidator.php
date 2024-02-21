<?php

declare(strict_types=1);

namespace App\RequestValidators\Employee;


use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

class EmployeeAddressesInfoRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups)
    {
    }

    public function validate(array $data): array
    {

        $v = new Validator($data);

        $v->rule('required', ['address', 'city', 'region', 'street', 'postal_code']);

        $v->rule('subset', 'city', array_keys($this->lookups->get('city')));


        $v->labels(array(
            'address' => 'عنوان السكن',
            'city' => 'المدينة',
            'region' => 'الحي',
            'street' => 'الشارع',
            'postal_code' => 'الرمز بريدي',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
