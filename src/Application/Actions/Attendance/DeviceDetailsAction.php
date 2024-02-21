<?php

namespace App\Application\Actions\Attendance;

use App\Models\Attendance;
use App\Application\Actions\Action;

use App\Models\Attendance\DevicesModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\RequestValidators\Attendance\DeviceStoreRequestValidator;
use App\RequestValidators\Attendance\DeviceSetUserRequestValidator;

class DeviceDetailsAction extends Action
{
    protected function action(): Response
    {
        // $data = $this->requestValidatorFactory->make(DeviceStoreRequestValidator::class)->validate($this->request->getParsedBody());
        // $data = $this->request->getParsedBody();

       // DevicesModel::all(); 
      

         return $this->response
         ->withHeader('Location', '/attendance/devices')
         ->withStatus(302);

    }



}
