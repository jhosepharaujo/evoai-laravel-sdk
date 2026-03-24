<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, string> */
readonly class TokenResponse implements Arrayable, \JsonSerializable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $access_token,
        public string $token_type,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            access_token: $data['access_token'],
            token_type: $data['token_type'],
        );
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->access_token,
            'token_type' => $this->token_type,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
