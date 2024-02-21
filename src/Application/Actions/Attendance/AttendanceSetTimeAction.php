<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;




use Rats\Zkteco\Lib\ZKTeco;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Attendance\DeviceCheckConnectRequestValidator;


class AttendanceSetTimeAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->requestValidatorFactory->make(DeviceCheckConnectRequestValidator::class)->validate($this->request->getParsedBody());

        $zk = new ZKTeco($data['device_ip']);
        $ip = $data['device_ip'];
        if ($zk->connect()) {
            date_default_timezone_set('Asia/Jerusalem');
            $serverTime = date('Y-m-d H:i:s');
            $zk->setTime($serverTime);
        } else {
            return $this->responseFormatter->asJson($this->response->withStatus(400), "IP : $ip  / الساعة غير متصلة");
        }

        return $this->responseFormatter->asJson($this->response, ' تم مزامنة الوقت بنجاح  ' . ' ' . $serverTime);
    }
}
