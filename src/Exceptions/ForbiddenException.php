<?php

namespace EvoAi\LaravelSdk\Exceptions;

use Illuminate\Http\Client\Response;

final class ForbiddenException extends EvoAiException
{
    public function __construct(Response $response, string $message = '')
    {
        parent::__construct($response, $message ?: 'Access forbidden.');
    }
}
