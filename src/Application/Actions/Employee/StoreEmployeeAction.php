<?php

declare(strict_types=1);

namespace App\Application\Actions\Employee;


use App\Models\Model;

use App\Application\Actions\Action;
use App\Models\Employee\EmployeeJobInfoModel;
use App\Models\Employee\EmployeeBasicInfoModel;
use App\Models\Employee\EmployeeContactsInfoModel;
use App\Models\Employee\EmployeeAddressesInfoModel;
use App\Models\Employee\EmployeeEducationInfoModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Employee\EmployeeBasicInfoRequestValidator;
use App\RequestValidators\Employee\EmployeeJobInfoRequestValidator;
use App\RequestValidators\Employee\EmployeeContactsInfoRequestValidator;
use App\RequestValidators\Employee\EmployeeAddressesInfoRequestValidator;
use App\RequestValidators\Employee\EmployeeEducationInfoRequestValidator;


class StoreEmployeeAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->requestValidatorFactory->make(EmployeeBasicInfoRequestValidator::class)->validate($this->request->getParsedBody());
        $data = $this->requestValidatorFactory->make(EmployeeJobInfoRequestValidator::class)->validate($data);
        $data = $this->requestValidatorFactory->make(EmployeeAddressesInfoRequestValidator::class)->validate($data);
        $data = $this->requestValidatorFactory->make(EmployeeEducationInfoRequestValidator::class)->validate($data);
        $data = $this->requestValidatorFactory->make(EmployeeContactsInfoRequestValidator::class)->validate($data);


        Model::start_tran();

        $result_basic_info = EmployeeBasicInfoModel::storeTran([
            $data['employee_no'],
            $data['f_name'],
            $data['s_name'],
            $data['t_name'],
            $data['l_name'],
            $data['en_name'],
            $data['gender'],
            $data['religion'],
            $data['birthday'],
            $data['birthplace'],
            $data['nationality'],
            $data['national_id'],
            $data['passport_no'],
            $data['marital_status'],
            $data['disability'],
            $data['disability_desc']
        ]);



        $employee_id = $result_basic_info['lastInsertId'];



        EmployeeJobInfoModel::storeTran([
            $employee_id,
            $data['contract_type'],
            $data['job_title'],
            $data['general_management'],
            $data['department'],
            $data['division'],
            $data['div'],
            $data['class'],
            $data['grade'],
            $data['job_start_date'],
            $data['job_end_date'],
        ]);



        EmployeeAddressesInfoModel::storeTran([
            $employee_id,
            $data['address'],
            $data['city'],
            $data['region'],
            $data['street'],
            $data['postal_code'],
        ]);

  


        EmployeeEducationInfoModel::storeTran([
            $employee_id,
            $data['academic_degree'],
            $data['unviersity'],
            $data['major'],
            $data['degree'],
            $data['edu_start_date'],
            $data['edu_end_date'],

        ]);


        EmployeeContactsInfoModel::storeTran([
            $employee_id,
            $data['g_email'],
            $data['g_mobile'],
            $data['g_telephone'],
            $data['p_email'],
            $data['p_mobile'],
            $data['p_telephone'],
        ]);


        Model::save_tran();




        return $this->view->render(
            $this->response,
            'employee/add.twig',
            
        );
    }
}
