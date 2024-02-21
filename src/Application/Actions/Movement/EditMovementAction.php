<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;


use App\Models\Model;
use App\RequestValidators\Movement\MovementRequestValidator;
use App\Application\Actions\Action;
use App\Models\Movement\MovementAddModel;
use App\Models\Employee\EmployeeModel;
use App\Models\Vehicle\VehicleListModel;
use Psr\Http\Message\ResponseInterface as Response;
class EditMovementAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       
        $id=($this->args["id"]);
        $data=MovementAddModel::viow_movement($id);
        $allEmploy = EmployeeModel::all();
        $allVehicle = VehicleListModel::all();
       //dd($data);
        return $this->view->render(
            $this->response,
            'movement/edit.twig',['data'=>$data['result'], 'allEmploy' => $allEmploy['result'], 'allVehicle' => $allVehicle['result']]); 
     }
}