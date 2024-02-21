<?php

declare(strict_types = 1);

namespace App\RequestValidators\Auth;

use PDO;
use Valitron\Validator;
use App\Contracts\ModelInterface;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

class AuthRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups )
    {
    }

    public function validate(array $data): array
    {
        //dd($this->lookups->get('religion'));
        $v = new Validator($data);

        $v->rule('required', ['employee_no', 'password']);
        $v->rule('numeric', 'employee_no');
        $v->rule('integer', 'employee_no');
        $v->rule('lengthMin', 'password', 8);

        $v->labels(array(
            'employee_no' => 'الرقم الوظيفي',
            'password' => 'كلمة المرور'
        ));
        
        if (! $v->validate()) {
            
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}