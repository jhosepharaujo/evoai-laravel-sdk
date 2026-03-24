<?php

namespace EvoAi\LaravelSdk\DTOs\Chat;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class ChatResponseData implements \JsonSerializable, Arrayable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $response,
        public array $message_history,
        public string $status,
        public string $timestamp,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            response: $data['response'] ?? '',
            message_history: $data['message_history'] ?? [],
            status: $data['status'] ?? 'completed',
            timestamp: $data['timestamp'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'response' => $this->response,
            'message_history' => $this->message_history,
            'status' => $this->status,
            'timestamp' => $this->timestamp,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
