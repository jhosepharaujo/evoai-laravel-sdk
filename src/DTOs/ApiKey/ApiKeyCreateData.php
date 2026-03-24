<?php

namespace EvoAi\LaravelSdk\DTOs\ApiKey;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class ApiKeyCreateData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $name,
        public string $provider,
        public string $client_id,
        #[\SensitiveParameter] public string $key_value,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            name: $data['name'],
            provider: $data['provider'],
            client_id: $data['client_id'],
            key_value: $data['key_value'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'provider' => $this->provider,
            'client_id' => $this->client_id,
            'key_value' => $this->key_value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
