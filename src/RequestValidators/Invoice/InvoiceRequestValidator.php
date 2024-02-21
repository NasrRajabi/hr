<?php

declare(strict_types=1);

namespace App\RequestValidators\Invoice;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class InvoiceRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['vehicle_id', 'invoice_date', 'invoice_type', 'invoice_no', 'invoice_value']);

  
        $v->labels(array(
            'vehicle_id' => 'المركبة',
            'invoice_date' => 'تاريخ الفاتورة',
            'invoice_type' => 'نوع الفاتورة',
            'invoice_no' => 'رقم الفاتورة',
            'invoice_value' => 'قيمة الفاتورة',
           
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
