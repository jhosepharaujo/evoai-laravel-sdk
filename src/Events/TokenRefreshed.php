<?php

namespace EvoAi\LaravelSdk\Events;

readonly class TokenRefreshed
{
    public function __construct(
        public float $durationMs,
    ) {}
}
