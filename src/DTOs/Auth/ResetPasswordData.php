<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class ResetPasswordData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $token,
        #[\SensitiveParameter] public string $new_password,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            token: $data['token'],
            new_password: $data['new_password'],
        );
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'new_password' => $this->new_password,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
