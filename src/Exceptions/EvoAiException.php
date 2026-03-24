<?php

namespace EvoAi\LaravelSdk\Exceptions;

use Illuminate\Http\Client\Response;

class EvoAiException extends \RuntimeException
{
    public function __construct(
        public readonly Response $response,
        string $message = '',
    ) {
        parent::__construct(
            $message ?: "Evo AI API error: {$response->status()} - {$response->body()}",
            $response->status(),
        );
    }

    /** @return array<string, mixed> */
    public function context(): array
    {
        return [
            'status' => $this->response->status(),
            'body' => $this->response->json(),
        ];
    }
}
