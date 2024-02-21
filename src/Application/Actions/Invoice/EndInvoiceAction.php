<?php

declare(strict_types=1);

namespace App\Application\Actions\Invoice;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Actions\Action;
use App\Models\Invoice\InvoiceAddModel;


class EndInvoiceAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        
       
        $data = $this->request->getParsedBody();
        //    dd($data);
        $id=($this->args["id"]);
        // $updated_by=($this->session->get("user_id"));

        InvoiceAddModel::updateEndInvoice($data["invoice_status"],$data["invoice_note_status"],$data["invoice_date_paid"], $id);
            return $this->response
            ->withHeader('Location', '/invoice/list')
            ->withStatus(302);
    }

}
