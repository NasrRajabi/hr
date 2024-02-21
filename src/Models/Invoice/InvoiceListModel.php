<?php

declare(strict_types=1);

namespace App\Models\Invoice;


use App\Models\Model;


class InvoiceListModel extends Model 
{
    public static function  all(): array
    {
        $sql = 'SELECT  *  FROM  invoice';
        $results =Model::query_get($sql);
        return $results;
    }
   

           

            

}

