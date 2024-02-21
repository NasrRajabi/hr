<?php

declare(strict_types=1);

namespace App\Application\Actions\Invoice;


use App\Models\Model;
use App\Application\Actions\Action;
use App\Models\Invoice\InvoiceListModel;
use Psr\Http\Message\ResponseInterface as Response;
    
    class ListInvoiceAction extends Action
    {
    
    
        /**
         * {@inheritdoc}
         */
        protected function action(): Response
        {
            $all = InvoiceListModel::all();
    
            $groupedData = [];
    
            foreach ($all['result'] as $item) {
                $name = $item->invoice_type;
    
                if (!array_key_exists($name, $groupedData)) {
                    $groupedData[$name] = [];
                }
    
                $groupedData[$name][] = $item;
            }
    
            // dd($groupedData);
            return $this->view->render(
                $this->response,
                'invoice/list.twig',
                ['data' => $groupedData ],
    
            );



            // $InvoiceListModel = new InvoiceListModel();
            // $data=$InvoiceListModel->all();
            
            //    return $this->view->render(
            //     $this->response,
            //     'invoice/list.twig',['data'=>$data['result'] ]
            // );
        }
    }
    