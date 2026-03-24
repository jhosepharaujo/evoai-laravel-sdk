<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class UserResponse implements Arrayable, \JsonSerializable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $email,
        public bool $is_active,
        public bool $is_admin,
        public ?string $client_id,
        public bool $email_verified,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            email: $data['email'],
            is_active: $data['is_active'] ?? true,
            is_admin: $data['is_admin'] ?? false,
            client_id: $data['client_id'] ?? null,
            email_verified: $data['email_verified'] ?? false,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'is_admin' => $this->is_admin,
            'client_id' => $this->client_id,
            'email_verified' => $this->email_verified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], fn (mixed $v): bool => $v !== null);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
