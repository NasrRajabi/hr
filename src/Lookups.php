<?php

declare(strict_types = 1);

namespace App;

use App\Contracts\LookupsInterface;

class Lookups implements LookupsInterface
{
    private array $lookups;

    public function __construct(array $lookups)
    {
        $this->lookups = $lookups;
    }

    /**
     * @return mixed
     */
    public function get(string $key = '')
    {
        return (empty($key)) ? $this->lookups : $this->lookups[$key];
    }
}


