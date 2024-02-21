<?php

declare(strict_types=1);

namespace App\Application\Actions\Attendance;




use Rats\Zkteco\Lib\ZKTeco;
use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use App\RequestValidators\Attendance\DeviceCheckConnectRequestValidator;


class AttendanceDeviceCheckConnectAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $data = $this->requestValidatorFactory->make(DeviceCheckConnectRequestValidator::class)->validate($this->request->getParsedBody());
       
        $zk = new ZKTeco($data['device_ip']);

        if (! $zk->connect()) {

            return $this->responseFormatter->asJson($this->response, 'not connected');
        }
        
        return $this->responseFormatter->asJson($this->response, 'connected');
    }

}
