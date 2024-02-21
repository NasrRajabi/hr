<?php

declare(strict_types = 1);

namespace App\DataObjects;

use App\Enum\SameSite;

/**
 * Summary of SessionConfig
 */
class SessionConfig
{

    public function __construct(
        public readonly string  $name       = 'HR',
        public readonly string  $flashName  = 'flash',
        public readonly bool    $secure     = true,
        public readonly bool    $httpOnly   = true,
        public readonly string  $sameSite   = 'lax'
    ) {
    }
}