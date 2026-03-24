<?php

namespace EvoAi\LaravelSdk\DTOs\Agent;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use EvoAi\LaravelSdk\Enums\AgentType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class AgentData implements \JsonSerializable, Arrayable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $client_id,
        public AgentType $type,
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
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            client_id: $data['client_id'],
            type: $data['type'] instanceof AgentType ? $data['type'] : AgentType::from($data['type']),
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
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'type' => $this->type->value,
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
