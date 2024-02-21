<?php

declare(strict_types=1);

namespace App\Contracts;

interface LookupsInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key = '');
}
