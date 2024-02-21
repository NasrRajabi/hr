<?php

declare(strict_types=1);

namespace App\RequestValidators\Employee;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class EmployeeBasicInfoRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['employee_no', 'f_name', 's_name', 't_name', 'l_name', 'en_name', 'gender', 'religion', 'birthday', 'birthplace', 'nationality', 'national_id', 'marital_status', 'disability']);
        $v->rule('regex', 'en_name','/^[a-zA-Z]+\s/');
        $v->rule('numeric', ['employee_no', 'national_id']);
        $v->rule('integer', ['employee_no', 'national_id']);
        $v->rule('lengthMin', 'national_id', 9);

        $v->rule('subset', 'gender', array_keys($this->lookups->get('gender')));
        $v->rule('subset', 'religion', array_keys($this->lookups->get('religion')));
        $v->rule('subset', 'nationality', array_keys($this->lookups->get('nationality')));
        $v->rule('subset', 'marital_status', array_keys($this->lookups->get('marital_status')));
        $v->rule('subset', 'disability', array_keys($this->lookups->get('boolean')));



        if ($data['disability'] === "1" && empty($data['disability_desc'])) {
            $v->rule('requiredWith', 'disability_desc', 'disability');
        } else {
            $data['disability_desc'] = '';
        }

        $v->rule(function ($field, $value, $params, $fields) {
            $user = $this->UserProviderService->getByCredentials(['employee_no' => (int) $value]);
            if ($user['rowCount'] === 1) {
                return false;
            }
            return true;
        }, "employee_no")->message("الرقم الوظيفي المدخل مكرر (محجوز لموظف آخر) يجيب ان يكون الرقم الوظيفي مميز");

        $v->labels(array(
            'employee_no' => 'الرقم الوظيفي',
            'f_name' => 'الاسم الاول',
            's_name' => 'الاسم الثاني',
            't_name' => 'الاسم الثالث',
            'l_name' => 'الاسم الرابع',
            'en_name' => 'الاسم بالانجليزي',
            'gender' => 'الجنس',
            'religion' => 'الديانة',
            'birthday' => 'تاريخ الميلاد',
            'birthplace' => 'مكان الولادة',
            'nationality' => 'الجنسية',
            'national_id' => 'رقم الهوية',
            'passport_no' => 'رقم جواز السفر',
            'marital_status' => 'الحالة الاجتماعية',
            'disability' => 'هل الموظف من ذوي الاحتياجات الخاصة',
            'disability_desc' => 'وصف العجز',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
