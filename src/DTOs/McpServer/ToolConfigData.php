<?php

namespace EvoAi\LaravelSdk\DTOs\McpServer;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class ToolConfigData implements \JsonSerializable, Arrayable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public array $tags = [],
        public array $examples = [],
        public array $inputModes = [],
        public array $outputModes = [],
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'],
            tags: $data['tags'] ?? [],
            examples: $data['examples'] ?? [],
            inputModes: $data['inputModes'] ?? [],
            outputModes: $data['outputModes'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'tags' => $this->tags,
            'examples' => $this->examples,
            'inputModes' => $this->inputModes,
            'outputModes' => $this->outputModes,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
