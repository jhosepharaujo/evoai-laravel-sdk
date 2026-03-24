<?php

namespace EvoAi\LaravelSdk\Exceptions;

use Illuminate\Http\Client\Response;

final class ValidationException extends EvoAiException
{
    public function __construct(Response $response, string $message = '')
    {
        parent::__construct($response, $message ?: 'Validation failed.');
    }

    /** @return array<int, array{loc: list<string|int>, msg: string, type: string}> */
    public function errors(): array
    {
        return $this->response->json('detail', []);
    }
}
