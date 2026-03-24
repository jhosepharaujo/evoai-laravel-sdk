<?php

namespace EvoAi\LaravelSdk\DTOs\Session;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Dumpable;

/** @implements Arrayable<string, mixed> */
readonly class SessionData implements \JsonSerializable, Arrayable
{
    use Dumpable;
    use HasFactory;

    public function __construct(
        public string $id,
        public string $app_name,
        public string $user_id,
        public array $state = [],
        public array $events = [],
        public float $last_update_time = 0.0,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            id: $data['id'],
            app_name: $data['app_name'],
            user_id: $data['user_id'],
            state: $data['state'] ?? [],
            events: $data['events'] ?? [],
            last_update_time: (float) ($data['last_update_time'] ?? 0.0),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'app_name' => $this->app_name,
            'user_id' => $this->user_id,
            'state' => $this->state,
            'events' => $this->events,
            'last_update_time' => $this->last_update_time,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
