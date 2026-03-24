<?php

namespace EvoAi\LaravelSdk\DTOs\ApiKey;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class ApiKeyData implements \JsonSerializable, Arrayable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $client_id,
        public string $name,
        public string $provider,
        public bool $is_active,
        public string $created_at,
        public ?string $updated_at = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            client_id: $data['client_id'],
            name: $data['name'],
            provider: $data['provider'],
            is_active: $data['is_active'] ?? true,
            created_at: $data['created_at'],
            updated_at: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'name' => $this->name,
            'provider' => $this->provider,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
