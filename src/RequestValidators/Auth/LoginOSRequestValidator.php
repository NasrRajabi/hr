<?php

declare(strict_types = 1);

namespace App\RequestValidators\Auth;

use PDO;
use Valitron\Validator;
use App\Contracts\ModelInterface;
use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

class LoginOSRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups )
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['os_id']);
        $v->rule('numeric', 'os_id');
        $v->rule('integer', 'os_id');
        // TODO_Aya: check the input label
        $v->labels(array(
            'os_id' => 'الوظيفة'
        ));
        
        if (! $v->validate()) {
            
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}