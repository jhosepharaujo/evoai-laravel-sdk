<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class ForgotPasswordData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $email,
    ) {}

    public static function from(array $data): static
    {
        return new static(email: $data['email']);
    }

    public function toArray(): array
    {
        return ['email' => $this->email];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
