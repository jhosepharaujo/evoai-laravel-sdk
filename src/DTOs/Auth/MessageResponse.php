<?php

namespace EvoAi\LaravelSdk\DTOs\Auth;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, string> */
readonly class MessageResponse implements Arrayable, \JsonSerializable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $message,
    ) {}

    public static function from(array $data): static
    {
        return new static(message: $data['message']);
    }

    public function toArray(): array
    {
        return ['message' => $this->message];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
