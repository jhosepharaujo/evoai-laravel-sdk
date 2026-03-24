<?php

use EvoAi\LaravelSdk\Support\TokenManager;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;

function makeTokenManager(bool $autoRefresh = true): TokenManager
{
    $cache = new Repository(new ArrayStore);

    return new TokenManager(
        cache: $cache,
        cacheKey: 'test_token',
        ttl: 3600,
        autoRefresh: $autoRefresh,
    );
}

it('stores and retrieves a token', function () {
    $manager = makeTokenManager();

    expect($manager->hasToken())->toBeFalse()
        ->and($manager->getToken())->toBeNull();

    $manager->setToken('my-jwt-token');

    expect($manager->hasToken())->toBeTrue()
        ->and($manager->getToken())->toBe('my-jwt-token');
});

it('clears a token', function () {
    $manager = makeTokenManager();
    $manager->setToken('token');
    $manager->clearToken();

    expect($manager->hasToken())->toBeFalse()
        ->and($manager->getToken())->toBeNull();
});

it('reports auto-refresh setting', function () {
    $enabled = makeTokenManager(autoRefresh: true);
    $disabled = makeTokenManager(autoRefresh: false);

    expect($enabled->shouldAutoRefresh())->toBeTrue()
        ->and($disabled->shouldAutoRefresh())->toBeFalse();
});
