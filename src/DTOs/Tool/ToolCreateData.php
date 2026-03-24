<?php

namespace EvoAi\LaravelSdk\DTOs\Tool;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class ToolCreateData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $name,
        public ?string $description = null,
        public array $config_json = [],
        public array $environments = [],
    ) {}

    public static function from(array $data): static
    {
        return new static(
            name: $data['name'],
            description: $data['description'] ?? null,
            config_json: $data['config_json'] ?? [],
            environments: $data['environments'] ?? [],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'config_json' => $this->config_json,
            'environments' => $this->environments,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
