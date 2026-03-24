<?php

namespace EvoAi\LaravelSdk\DTOs\Folder;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class FolderData implements Arrayable, \JsonSerializable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $client_id,
        public string $name,
        public ?string $description,
        public string $created_at,
        public ?string $updated_at = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            client_id: $data['client_id'],
            name: $data['name'],
            description: $data['description'] ?? null,
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
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
