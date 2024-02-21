<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;




use Rats\Zkteco\Lib\ZKTeco;
use App\Models\Auth\AuthModel;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Attendance\DeviceSetUserRequestValidator;


class AttendanceDeviceSetUserAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->requestValidatorFactory->make(DeviceSetUserRequestValidator::class)->validate($this->request->getParsedBody());
        $newEmployee = AuthModel::findOneByEmployeeNo($data['employee_no']);
        $zk = new ZKTeco($data['device_ip']);

        if ($zk->connect()) {
            $employees = $zk->getUser();
            if ($this->isNotSet($employees, $newEmployee)) {            
                $zk->setUser($newEmployee['result']->id,  $newEmployee['result']->id, $newEmployee['result']->en_name, '123', $data['role']);
                $users = $newEmployee;
            }
            else {  
                return $this->responseFormatter->asJson($this->response->withStatus(400), 'الموظف معرف مسبقاً على الساعة');
            }
        } else {
            return $this->responseFormatter->asJson($this->response->withStatus(400), 'الساعة غير متصلة');
        }
        
        return $this->responseFormatter->asJson($this->response, 'تم اضافة الموظف '.  $newEmployee['result']->f_name .' '. $newEmployee['result']->s_name.' '.  $newEmployee['result']->l_name .' صاحب الرقم '. $newEmployee['result']->employee_no.' على الساعة بنجاح');
    }

    private function isNotSet($employees, $newEmployee): bool
    {
        foreach ($employees as $employee) {
            if ($newEmployee['result']->id == (int) $employee['uid'] || $newEmployee['result']->employee_no == (int) $employee['userid']) {
                return false;
            }
        }
        return true;
    }
}
