<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class ChangePasswordData implements \JsonSerializable, Arrayable
{
    use HasFactory;

    public function __construct(
        #[\SensitiveParameter] public string $current_password,
        #[\SensitiveParameter] public string $new_password,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            current_password: $data['current_password'],
            new_password: $data['new_password'],
        );
    }

    public function toArray(): array
    {
        return [
            'current_password' => $this->current_password,
            'new_password' => $this->new_password,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
