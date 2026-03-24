<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class RegisterData implements \JsonSerializable, Arrayable
{
    use HasFactory;

    public function __construct(
        public string $email,
        #[\SensitiveParameter] public string $password,
        public string $name,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            email: $data['email'],
            password: $data['password'],
            name: $data['name'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
