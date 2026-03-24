<?php

namespace EvoAi\LaravelSdk\DTOs\McpServer;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class McpServerCreateData implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public string $name,
        public ?string $description = null,
        public string $config_type = 'studio',
        public array $config_json = [],
        public array $environments = [],
        public ?array $tools = null,
        public string $type = 'official',
    ) {}

    public static function from(array $data): static
    {
        return new static(
            name: $data['name'],
            description: $data['description'] ?? null,
            config_type: $data['config_type'] ?? 'studio',
            config_json: $data['config_json'] ?? [],
            environments: $data['environments'] ?? [],
            tools: $data['tools'] ?? null,
            type: $data['type'] ?? 'official',
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'config_type' => $this->config_type,
            'config_json' => $this->config_json,
            'environments' => $this->environments,
            'tools' => $this->tools,
            'type' => $this->type,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
