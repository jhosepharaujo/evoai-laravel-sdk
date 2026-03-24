<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class LoginData implements \JsonSerializable, Arrayable
{
    use HasFactory;

    public function __construct(
        public string $email,
        #[\SensitiveParameter] public string $password,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            email: $data['email'],
            password: $data['password'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
