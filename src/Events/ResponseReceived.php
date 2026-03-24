<?php

namespace EvoAi\LaravelSdk\Events;

readonly class ResponseReceived
{
    public function __construct(
        public string $method,
        public string $url,
        public int $statusCode,
        public ?array $response,
        public float $durationMs,
    ) {}
}
