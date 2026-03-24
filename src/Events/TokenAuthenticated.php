<?php

namespace EvoAi\LaravelSdk\Events;

readonly class TokenAuthenticated
{
    public function __construct(
        public string $email,
        public float $durationMs,
    ) {}
}
