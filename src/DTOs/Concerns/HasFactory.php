<?php

namespace EvoAi\LaravelSdk\DTOs\Concerns;

/** @template TArray of array */
trait HasFactory
{
    /** @param TArray $data */
    abstract public static function from(array $data): static;

    /** @return TArray */
    abstract public function toArray(): array;

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options | JSON_THROW_ON_ERROR);
    }
}
