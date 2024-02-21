<?php

declare(strict_types=1);

namespace App\Application\Actions\Vehicle;


use App\Models\Model;
use App\RequestValidators\Vehicle\VehicleRequestValidator;
use App\Application\Actions\Action;
use App\Models\Vehicle\VehicleAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class EditVehicleAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       
        $id=($this->args["id"]);
        $data=VehicleAddModel::viow_vehicle($id);
       
       //dd($data);
        return $this->view->render(
            $this->response,
            'vehicle/edit.twig',['data'=>$data['result']]); 
     }
}