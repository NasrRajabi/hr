<?php

declare(strict_types=1);

namespace App\Models\Invoice;


use App\Models\Model;


class InvoiceAddModel
{


    public static function store(array $basic_info): array
    {

        $sql = 'INSERT INTO invoice(vehicle_id,invoice_type, invoice_date,invoice_no, invoice_value, invoice_note, invoice_status,created_by,created_at)
                        VALUES (?,?,?,?,?,?,?,?,?)';

        $results = Model::query_set($sql, $basic_info);
        return $results;
    }
    public static function viow_invoice($id): array
    {
        $sql='select * 
        from invoice
        where invoice.id= ? ';
            $results =Model::query_get($sql,[$id]);
            return $results;
    }

    public static function updateInvoice($vehicle_id, $invoice_type,$invoice_date, $invoice_no,$invoice_value, $invoice_note, $id ): array
    {
        
                $sql = "UPDATE invoice SET vehicle_id=?, invoice_type=?, invoice_date=?, invoice_no=?, invoice_value=?, invoice_note=? WHERE id=?";

        return Model::query_up($sql, [$vehicle_id, $invoice_type,$invoice_date, $invoice_no,$invoice_value, $invoice_note, $id]);
    }
   
    public static function updateEndInvoice($invoice_status,$invoice_note_status,$invoice_date_paid, $id ): array
    {
        
                $sql = "UPDATE invoice SET invoice_status=?, invoice_note_status=?, invoice_date_paid=? WHERE id=?";

        return Model::query_up($sql, [$invoice_status, $invoice_note_status, $invoice_date_paid, $id]);
    }
    

}
