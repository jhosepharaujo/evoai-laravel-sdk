<?php

namespace EvoAi\LaravelSdk\Events;

readonly class RequestSending
{
    public function __construct(
        public string $method,
        public string $url,
        public ?array $payload = null,
    ) {}
}
