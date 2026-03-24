<?php

namespace EvoAi\LaravelSdk\Exceptions;

use Illuminate\Http\Client\Response;

final class NotFoundException extends EvoAiException
{
    public function __construct(Response $response, string $message = '')
    {
        parent::__construct($response, $message ?: 'Resource not found.');
    }
}
