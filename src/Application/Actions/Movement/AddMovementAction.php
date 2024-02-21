<?php

declare(strict_types=1);

namespace App\Application\Actions\Movement;


use App\Application\Actions\Action;
use App\Models\Employee\EmployeeModel;
use App\Models\Vehicle\VehicleListModel;
use Psr\Http\Message\ResponseInterface as Response;

class AddMovementAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      
        $allEmploy = EmployeeModel::all();
        $allVehicle = VehicleListModel::all();
         return $this->view->render(
            $this->response,
            'movement/add.twig',['allEmploy'=>$allEmploy['result'],'allVehicle'=>$allVehicle['result']]
        );
    }
}
