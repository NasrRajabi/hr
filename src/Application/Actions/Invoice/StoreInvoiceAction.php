<?php

declare(strict_types=1);

namespace App\Application\Actions\Invoice;


use App\Models\Model;
use App\RequestValidators\Invoice\InvoiceRequestValidator;
use App\Application\Actions\Action;
use App\Models\Invoice\InvoiceAddModel;
use Psr\Http\Message\ResponseInterface as Response;
class StoreInvoiceAction extends Action
{
//LeaveRequestValidator

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->requestValidatorFactory->make(InvoiceRequestValidator::class)->validate($this->request->getParsedBody());
      
      InvoiceAddModel::store([
            $data['vehicle_id'],
            $data['invoice_type'],
            $data['invoice_date'],
            $data['invoice_no'],
            $data['invoice_value'],
            $data['invoice_note'],
            $data['invoice_status']=1,
            $data['created_by']=$this->session->get("user_id"),
            $data['created_at']=date("Y-m-d")          
        ]);
    

            return $this->response
            ->withHeader('Location', '/invoice/list')
            ->withStatus(302);
        
    }
}
