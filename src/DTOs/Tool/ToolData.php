<?php

namespace EvoAi\LaravelSdk\DTOs\Tool;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class ToolData implements \JsonSerializable, Arrayable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public array $config_json,
        public array $environments,
        public string $created_at,
        public ?string $updated_at = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            config_json: $data['config_json'] ?? [],
            environments: $data['environments'] ?? [],
            created_at: $data['created_at'],
            updated_at: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'config_json' => $this->config_json,
            'environments' => $this->environments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
