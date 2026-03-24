<?php

namespace EvoAi\LaravelSdk\DTOs\Client;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class ClientData implements Arrayable, \JsonSerializable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $name,
        public ?string $email,
        public string $created_at,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'] ?? null,
            created_at: $data['created_at'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
