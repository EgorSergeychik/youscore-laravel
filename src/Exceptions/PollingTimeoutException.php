<?php

namespace EgorSergeychik\YouScore\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class PollingTimeoutException extends Exception
{
    public function __construct(
        string $message,
        public readonly Response $response
    ) {
        parent::__construct($message);
    }
}
