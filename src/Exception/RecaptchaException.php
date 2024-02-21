<?php

declare(strict_types = 1);

namespace App\Exception;

use Throwable;

class RecaptchaException extends \RuntimeException
{
    public function __construct(
        public readonly array $errors,
        string $message = 'Recaptcha Error(s)',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}