<?php

namespace EvoAi\LaravelSdk\DTOs\Client;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class ClientUpdateData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $name,
        public ?string $email = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            name: $data['name'],
            email: $data['email'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
