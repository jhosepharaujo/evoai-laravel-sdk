<?php

use EvoAi\LaravelSdk\Support\EvoAiPaginator;

it('calculates current page from skip and limit', function () {
    $paginator = new EvoAiPaginator(items: ['a', 'b', 'c'], skip: 0, limit: 10);
    expect($paginator->currentPage())->toBe(1);

    $paginator = new EvoAiPaginator(items: ['a', 'b'], skip: 10, limit: 10);
    expect($paginator->currentPage())->toBe(2);

    $paginator = new EvoAiPaginator(items: ['a'], skip: 20, limit: 10);
    expect($paginator->currentPage())->toBe(3);
});

it('detects if there are more items', function () {
    $paginator = new EvoAiPaginator(items: array_fill(0, 10, 'x'), skip: 0, limit: 10);
    expect($paginator->hasMore())->toBeTrue();

    $paginator = new EvoAiPaginator(items: array_fill(0, 5, 'x'), skip: 0, limit: 10);
    expect($paginator->hasMore())->toBeFalse();
});

it('calculates next skip value', function () {
    $paginator = new EvoAiPaginator(items: [], skip: 0, limit: 20);
    expect($paginator->nextSkip())->toBe(20);

    $paginator = new EvoAiPaginator(items: [], skip: 40, limit: 20);
    expect($paginator->nextSkip())->toBe(60);
});

it('is countable', function () {
    $paginator = new EvoAiPaginator(items: ['a', 'b', 'c'], skip: 0, limit: 10);
    expect($paginator)->toHaveCount(3)
        ->and(count($paginator))->toBe(3);
});

it('is iterable', function () {
    $items = ['a', 'b', 'c'];
    $paginator = new EvoAiPaginator(items: $items, skip: 0, limit: 10);

    $collected = [];
    foreach ($paginator as $item) {
        $collected[] = $item;
    }

    expect($collected)->toBe($items);
});

it('reports empty state', function () {
    $empty = new EvoAiPaginator(items: [], skip: 0, limit: 10);
    $nonEmpty = new EvoAiPaginator(items: ['a'], skip: 0, limit: 10);

    expect($empty->isEmpty())->toBeTrue()
        ->and($empty->isNotEmpty())->toBeFalse()
        ->and($nonEmpty->isEmpty())->toBeFalse()
        ->and($nonEmpty->isNotEmpty())->toBeTrue();
});

it('serializes to JSON with meta', function () {
    $paginator = new EvoAiPaginator(items: ['a', 'b'], skip: 10, limit: 5, total: 50);

    $json = $paginator->jsonSerialize();

    expect($json)->toHaveKey('data')
        ->and($json)->toHaveKey('meta')
        ->and($json['meta']['skip'])->toBe(10)
        ->and($json['meta']['limit'])->toBe(5)
        ->and($json['meta']['current_page'])->toBe(3)
        ->and($json['meta']['total'])->toBe(50);
});

it('returns per page value', function () {
    $paginator = new EvoAiPaginator(items: [], skip: 0, limit: 25);
    expect($paginator->perPage())->toBe(25);
});

it('returns total when available', function () {
    $withTotal = new EvoAiPaginator(items: [], skip: 0, limit: 10, total: 100);
    $withoutTotal = new EvoAiPaginator(items: [], skip: 0, limit: 10);

    expect($withTotal->total())->toBe(100)
        ->and($withoutTotal->total())->toBeNull();
});
