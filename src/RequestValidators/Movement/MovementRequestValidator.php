<?php

declare(strict_types=1);

namespace App\RequestValidators\Movement;

use PDO;
use Valitron\Validator;

use App\Contracts\LookupsInterface;
use App\Exception\ValidationException;
use App\Contracts\RequestValidatorInterface;
use App\Contracts\UserProviderServiceInterface;

class MovementRequestValidator implements RequestValidatorInterface
{
    public function __construct(private readonly LookupsInterface $lookups, private readonly UserProviderServiceInterface $UserProviderService)
    {
    }

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['vehicle_id', 'itinerary', 'movement_date', 'driver', 'starting_hour', 'star_counter_no']);

  
        $v->labels(array(
            'vehicle_id' => 'المركبة',
            'itinerary' => 'خط السير',
            'movement_date' => 'تاريخ الحركة',
            'driver' => 'السائق',
            'starting_hour' => 'ساعة البداية',
            'star_counter_no' => 'عداد البداية',
        ));

        if (!$v->validate()) {

            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
