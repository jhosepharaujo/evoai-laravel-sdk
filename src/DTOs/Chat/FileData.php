<?php

namespace EvoAi\LaravelSdk\DTOs\Chat;

use EvoAi\LaravelSdk\DTOs\Concerns\HasFactory;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, string> */
readonly class FileData implements \JsonSerializable, Arrayable
{
    use HasFactory;

    public function __construct(
        public string $filename,
        public string $content_type,
        public string $data,
    ) {}

    public static function from(array $data): static
    {
        return new static(
            filename: $data['filename'],
            content_type: $data['content_type'],
            data: $data['data'],
        );
    }

    public function toArray(): array
    {
        return [
            'filename' => $this->filename,
            'content_type' => $this->content_type,
            'data' => $this->data,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
