<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;




use Rats\Zkteco\Lib\ZKTeco;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Attendance\DeviceRemoveUserRequestValidator;




class AttendanceRemoveUserAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->requestValidatorFactory->make(DeviceRemoveUserRequestValidator::class)->validate($this->request->getParsedBody());
        

        $zk = new ZKTeco($data['device_ip']);

        if ($zk->connect()) {
            $zk->removeUser($data['employee_id']);
        } else {
            return $this->responseFormatter->asJson($this->response->withStatus(400), 'الساعة غير متصلة');
        }

        return $this->responseFormatter->asJson($this->response, 'تم حذف الموظف عن الساعة بنجاح');
    }
}
