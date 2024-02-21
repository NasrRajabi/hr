<?php

declare(strict_types=1);

namespace App\RequestValidators\Employee;


use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

class EmployeeEducationInfoRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups)
    {
    }

    public function validate(array $data): array
    {
  
        $v = new Validator($data);

        $v->rule('required', ['academic_degree', 'unviersity', 'major', 'degree', 'edu_start_date', 'edu_end_date']);

        $v->rule('subset', 'city', array_keys($this->lookups->get('city')));
        $v->rule('subset', 'academic_degree', array_keys($this->lookups->get('academic_degree')));
        $v->rule('subset', 'degree', array_keys($this->lookups->get('degree')));


        $v->labels(array(
            'academic_degree' => 'الدرجة العلمية',
            'unviersity' => 'الجامعة / المدرسة',
            'major' => 'التخصص/ الفرع',
            'degree' => 'التقدير',
            'edu_start_date' => 'تاريخ الالتحاق',
            'edu_end_date' => 'تاريخ التخرج',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
