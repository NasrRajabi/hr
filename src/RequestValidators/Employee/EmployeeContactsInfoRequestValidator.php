<?php

declare(strict_types=1);

namespace App\RequestValidators\Employee;


use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

class EmployeeContactsInfoRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups)
    {
    }

    public function validate(array $data): array
    {

        $v = new Validator($data);

        $v->rule('required', ['p_email', 'p_mobile']);
        $v->rule('email', ['g_email', 'p_email']);
        $v->rule('numeric', ['g_mobile', 'p_mobile', 'g_telephone', 'p_telephone']);
        $v->rule('lengthMin', 'g_mobile', 10);
        $v->rule('lengthMin', 'p_mobile', 10);
       

        $v->labels(array(
            'g_email' => '(الايميل الحكومي)',
            'g_mobile' => 'رقم الهاتف المحمول الحكومي',
            'g_telephone' => 'رقم الهاتف الداخلي',
            'p_email' => '(الايميل الشخصي)',
            'p_mobile' => 'رقم الهاتف المحمول الشخصي',
            'p_telephone' => 'رقم الهاتف الارضي الشخصي',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
