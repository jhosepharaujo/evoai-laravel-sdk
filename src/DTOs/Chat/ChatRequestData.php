<?php

namespace EvoAi\LaravelSdk\DTOs\Chat;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
readonly class ChatRequestData implements \JsonSerializable, Arrayable
{
    use HasFactory;

    /**
     * @param  list<FileData>|null  $files
     */
    public function __construct(
        public string $message,
        public ?string $agent_id = null,
        public ?string $external_id = null,
        public ?array $files = null,
    ) {}

    public static function from(array $data): static
    {
        $files = isset($data['files'])
            ? array_map(fn (array $f) => FileData::from($f), $data['files'])
            : null;

        return new static(
            message: $data['message'],
            agent_id: $data['agent_id'] ?? null,
            external_id: $data['external_id'] ?? null,
            files: $files,
        );
    }

    public function toArray(): array
    {
        $data = ['message' => $this->message];

        if ($this->agent_id !== null) {
            $data['agent_id'] = $this->agent_id;
        }

        if ($this->external_id !== null) {
            $data['external_id'] = $this->external_id;
        }

        if ($this->files !== null) {
            $data['files'] = array_map(fn (FileData $f) => $f->toArray(), $this->files);
        }

        return $data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
