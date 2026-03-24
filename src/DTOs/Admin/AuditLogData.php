<?php

namespace EvoAi\LaravelSdk\DTOs\Admin;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class AuditLogData implements Arrayable, \JsonSerializable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $action,
        public string $resource_type,
        public ?string $resource_id = null,
        public ?array $details = null,
        public ?string $user_id = null,
        public ?string $ip_address = null,
        public ?string $user_agent = null,
        public string $created_at = '',
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            action: $data['action'],
            resource_type: $data['resource_type'],
            resource_id: $data['resource_id'] ?? null,
            details: $data['details'] ?? null,
            user_id: $data['user_id'] ?? null,
            ip_address: $data['ip_address'] ?? null,
            user_agent: $data['user_agent'] ?? null,
            created_at: $data['created_at'] ?? '',
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'action' => $this->action,
            'resource_type' => $this->resource_type,
            'resource_id' => $this->resource_id,
            'details' => $this->details,
            'user_id' => $this->user_id,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
