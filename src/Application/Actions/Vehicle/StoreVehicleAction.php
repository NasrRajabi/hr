<?php

declare(strict_types=1);

namespace App\Application\Actions\Vehicle;


use App\Models\Model;
use App\RequestValidators\Vehicle\VehicleRequestValidator;
use App\Application\Actions\Action;
use App\Models\Vehicle\VehicleAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class StoreVehicleAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->requestValidatorFactory->make(VehicleRequestValidator::class)->validate($this->request->getParsedBody());
      
        VehicleAddModel::store([
            $data['vehicle_no'],
            $data['vehicle_name'],
            $data['vehicle_type'],
            $data['chassis_no'],
            $data['engine_no'],
            $data['engine_capacity'],
            $data['vehicle_model'],
            $data['fuel_type'],
            $data['lime_type'],
            $data['vehicle_color'],
            $data['created_by']=$this->session->get("user_id"),
            $data['created_at']=date("Y-m-d")          
        ]);
            return $this->response
            ->withHeader('Location', '/vehicle/add')
            ->withStatus(302);
        
    }
}
