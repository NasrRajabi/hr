<?php

declare(strict_types=1);

namespace App\RequestValidators\Auth;

use PDO;
use App\Auth;
use Valitron\Validator;
use App\Contracts\ModelInterface;
use App\Contracts\LookupsInterface;
use App\Contracts\SessionInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Models\Employee\EmployeeBasicInfoModel;

class LoginFirstRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups,  protected readonly SessionInterface $session)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['new_password', 'confirm_new_password']);
        $v->rule('equals', 'new_password', 'confirm_new_password');
        $v->rule('equals', 'confirm_new_password', 'new_password');

        $v->rule('lengthMin', 'new_password', 8);
        $v->rule('lengthMin', 'confirm_new_password', 8);


        $v->rule(function ($field, $value, $params, $fields) {
            $hasUppercase = preg_match('/[A-Z]/', $value);
            $hasLowercase = preg_match('/[a-z]/', $value);
            $hasDigit = preg_match('/\d/', $value);
            $hasSpecialChar = preg_match('/[^a-zA-Z\d]/', $value);
            // Check if the password meets all criteria
            if ($hasUppercase && $hasLowercase && $hasDigit && $hasSpecialChar) {
                return true; // Password is strong
            }
            return false; // Password is not strong

        }, "new_password")->message("كلمة المرور ضعيفة يجب ان تحتوي كلمة المرور على حروف كبيرة وحروف صغيرة وارقام ورموز");

        $v->rule(function ($field, $value, $params, $fields) {
            $hasUppercase = preg_match('/[A-Z]/', $value);
            $hasLowercase = preg_match('/[a-z]/', $value);
            $hasDigit = preg_match('/\d/', $value);
            $hasSpecialChar = preg_match('/[^a-zA-Z\d]/', $value);
            // Check if the password meets all criteria
            if ($hasUppercase && $hasLowercase && $hasDigit && $hasSpecialChar) {
                return true; // Password is strong
            }
            return false; // Password is not strong

        }, "confirm_new_password")->message("كلمة المرور ضعيفة يجب ان تحتوي كلمة المرور على حروف كبيرة وحروف صغيرة وارقام ورموز");



        $v->rule(function ($field, $value, $params, $fields) {
            $employee = EmployeeBasicInfoModel::getEmpById($this->session->get('user_id'));
            if( password_verify($value, $employee['result']->password))
            {
                return false;
            }
            return true;
        }, "new_password")->message("يجب ان تكون كلمة المرور الجديدة مختلفة عن القديمة");


        $v->labels(array(
            'new_password' => 'كلمة المرور الجديدة',
            'confirm_new_password' => 'تأكيد كلمة المرور الجديدة'
        ));


        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
