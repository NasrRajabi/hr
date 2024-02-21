<?php

declare(strict_types=1);

namespace App\Application\Actions\Invoice;


use App\Application\Actions\Action;
use App\Models\Vehicle\VehicleListModel;
use Psr\Http\Message\ResponseInterface as Response;

class AddInvoiceAction extends Action
{


    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
      
        $allVehicle = VehicleListModel::all();
         return $this->view->render(
            $this->response,
            'invoice/add.twig',['allVehicle'=>$allVehicle['result']]
        );
    }
}
