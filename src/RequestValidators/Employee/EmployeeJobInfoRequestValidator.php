<?php

declare(strict_types=1);

namespace App\RequestValidators\Employee;


use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;

class EmployeeJobInfoRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['contract_type', 'job_title', /*'general_management', 'class', 'grade',*/ 'job_start_date']);

        $v->rule('subset', 'contract_type', array_keys($this->lookups->get('contract_type')));
        $v->rule('subset', 'job_title', array_keys($this->lookups->get('job_title')));

        // $v->rule('subset', 'general_management', array_keys($this->lookups->get('general_management')));

        // if ($data['department'] !== "null" ) {
        //     $v->rule('subset', 'department', array_keys($this->lookups->get('department')));
        // }
        // if ($data['division'] !== "null" ) {
        //     $v->rule('subset', 'division', array_keys($this->lookups->get('division')));
        // }
        // if ($data['div'] !== "null" ) {
        //     $v->rule('subset', 'div', array_keys($this->lookups->get('div')));
        // }


        $v->labels(array(
            'contract_type' => 'نوع العقد',
            'job_title' => 'المسمى الوظيفي',
            'general_management' => 'الادارة العامة',
            'department' => 'الدائرة',
            'division' => 'القسم',
            'div' => 'الشعبة',
            'class' => 'الفئة',
            'grade' => 'الدرجة',
            'job_start_date' => 'تاريخ استلام العمل',
            'job_end_date' => 'تاريخ انتهاء العمل',
        ));

        if (!$v->validate()) {
dd($v->errors());
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
