<?php

declare(strict_types=1);

namespace App\Application\Actions\Invoice;


use App\Models\Model;
use App\Application\Actions\Action;
use App\Models\Invoice\InvoiceAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class UpdateInvoiceAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
       $data = $this->request->getParsedBody();
    //    dd($data);
    $id=($this->args["id"]);
// dd($data["id"]);die;
    InvoiceAddModel::updateInvoice($data["vehicle_id"],$data["invoice_type"],$data["invoice_date"],$data["invoice_no"],$data["invoice_value"],$data["invoice_note"],$id);
        return $this->response
        ->withHeader('Location', '/invoice/list')
        ->withStatus(302);
        
    }

   
}