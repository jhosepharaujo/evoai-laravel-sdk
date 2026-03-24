<?php

namespace EvoAi\LaravelSdk\Support;

/**
 * @template TItem
 *
 * @implements \IteratorAggregate<int, TItem>
 */
final readonly class EvoAiPaginator implements \Countable, \IteratorAggregate, \JsonSerializable
{
    /**
     * @param  list<TItem>  $items
     */
    public function __construct(
        private array $items,
        private int $skip,
        private int $limit,
        private ?int $total = null,
    ) {}

    /** @return list<TItem> */
    public function items(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->items === [];
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    public function hasMore(): bool
    {
        return $this->count() >= $this->limit;
    }

    public function nextSkip(): int
    {
        return $this->skip + $this->limit;
    }

    public function perPage(): int
    {
        return $this->limit;
    }

    public function currentPage(): int
    {
        return (int) floor($this->skip / max($this->limit, 1)) + 1;
    }

    public function total(): ?int
    {
        return $this->total;
    }

    /** @return \ArrayIterator<int, TItem> */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function jsonSerialize(): array
    {
        return [
            'data' => $this->items,
            'meta' => [
                'skip' => $this->skip,
                'limit' => $this->limit,
                'current_page' => $this->currentPage(),
                'has_more' => $this->hasMore(),
                'total' => $this->total,
            ],
        ];
    }
}
