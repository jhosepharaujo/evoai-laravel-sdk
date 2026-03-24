<?php

namespace EvoAi\LaravelSdk\DTOs\Agent;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use EvoAi\LaravelSdk\Enums\AgentType;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class AgentUpdateData implements \JsonSerializable, Arrayable
{
    use HasFactory;

    public function __construct(
        public ?AgentType $type = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $role = null,
        public ?string $goal = null,
        public ?string $model = null,
        public ?string $api_key_id = null,
        public ?string $instruction = null,
        public ?string $agent_card_url = null,
        public ?string $folder_id = null,
        public ?array $config = null,
    ) {}

    public static function from(array $data): static
    {
        $type = isset($data['type'])
            ? ($data['type'] instanceof AgentType ? $data['type'] : AgentType::from($data['type']))
            : null;

        return new static(
            type: $type,
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            role: $data['role'] ?? null,
            goal: $data['goal'] ?? null,
            model: $data['model'] ?? null,
            api_key_id: $data['api_key_id'] ?? null,
            instruction: $data['instruction'] ?? null,
            agent_card_url: $data['agent_card_url'] ?? null,
            folder_id: $data['folder_id'] ?? null,
            config: $data['config'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type?->value,
            'name' => $this->name,
            'description' => $this->description,
            'role' => $this->role,
            'goal' => $this->goal,
            'model' => $this->model,
            'api_key_id' => $this->api_key_id,
            'instruction' => $this->instruction,
            'agent_card_url' => $this->agent_card_url,
            'folder_id' => $this->folder_id,
            'config' => $this->config,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
