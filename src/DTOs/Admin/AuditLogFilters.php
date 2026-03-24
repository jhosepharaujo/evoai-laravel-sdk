<?php

namespace EvoAi\LaravelSdk\DTOs\Admin;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class AuditLogFilters implements Arrayable, \JsonSerializable
{
    use HasFactory;

    public function __construct(
        public ?string $user_id = null,
        public ?string $action = null,
        public ?string $resource_type = null,
        public ?string $resource_id = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public int $skip = 0,
        public int $limit = 100,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            user_id: $data['user_id'] ?? null,
            action: $data['action'] ?? null,
            resource_type: $data['resource_type'] ?? null,
            resource_id: $data['resource_id'] ?? null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
            skip: $data['skip'] ?? 0,
            limit: $data['limit'] ?? 100,
        );
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
