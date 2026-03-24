<?php

namespace EvoAi\LaravelSdk\DTOs\Folder;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class FolderCreateData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $name,
        public string $client_id,
        public ?string $description = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            name: $data['name'],
            client_id: $data['client_id'],
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'client_id' => $this->client_id,
            'description' => $this->description,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
