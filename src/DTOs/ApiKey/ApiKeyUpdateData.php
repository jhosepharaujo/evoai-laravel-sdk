<?php

namespace EvoAi\LaravelSdk\DTOs\ApiKey;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class ApiKeyUpdateData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public ?string $name = null,
        public ?string $provider = null,
        #[\SensitiveParameter] public ?string $key_value = null,
        public ?bool $is_active = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            name: $data['name'] ?? null,
            provider: $data['provider'] ?? null,
            key_value: $data['key_value'] ?? null,
            is_active: $data['is_active'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'provider' => $this->provider,
            'key_value' => $this->key_value,
            'is_active' => $this->is_active,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
