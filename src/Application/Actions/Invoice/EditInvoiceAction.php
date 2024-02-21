<?php

declare(strict_types=1);

namespace App\Application\Actions\Invoice;


use App\Models\Model;
use App\Application\Actions\Action;
use App\Models\Invoice\InvoiceAddModel;
use App\Models\Vehicle\VehicleListModel;
use Psr\Http\Message\ResponseInterface as Response;
class EditInvoiceAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       
        $id=($this->args["id"]);
        $data=InvoiceAddModel::viow_invoice($id);
        $allVehicle = VehicleListModel::all();
       //dd($data);
        return $this->view->render(
            $this->response,
            'invoice/edit.twig',['data'=>$data['result'], 'allVehicle' => $allVehicle['result']]); 
     }
}