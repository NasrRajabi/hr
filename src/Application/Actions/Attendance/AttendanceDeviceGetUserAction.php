<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;


use Rats\Zkteco\Lib\ZKTeco;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Attendance\DeviceGetUserRequestValidator;

class AttendanceDeviceGetUserAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->requestValidatorFactory->make(DeviceGetUserRequestValidator::class)->validate($this->request->getParsedBody());

        $zk = new ZKTeco($data['device_ip'], 4370);

        if ($zk->connect()) {
            $users = $zk->getUser();
        } else {
            return $this->responseFormatter->asJson($this->response->withStatus(400), 'الساعة غير متصلة');
        }
        $users['device_ip'] = $data['device_ip'];
        return $this->responseFormatter->asJson($this->response, $users);
    }
}
