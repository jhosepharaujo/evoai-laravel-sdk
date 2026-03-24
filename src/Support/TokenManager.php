<?php

namespace EvoAi\LaravelSdk\Support;

use Illuminate\Contracts\Cache\Repository as CacheRepository;

final class TokenManager
{
    public function __construct(
        private readonly CacheRepository $cache,
        private readonly string $cacheKey,
        private readonly int $ttl,
        private readonly bool $autoRefresh,
    ) {}

    public function getToken(): ?string
    {
        return $this->cache->get($this->cacheKey);
    }

    public function setToken(
        #[\SensitiveParameter] string $token,
        ?int $ttl = null,
    ): void {
        $this->cache->put($this->cacheKey, $token, $ttl ?? $this->ttl);
    }

    public function clearToken(): void
    {
        $this->cache->forget($this->cacheKey);
    }

    public function hasToken(): bool
    {
        return $this->cache->has($this->cacheKey);
    }

    public function shouldAutoRefresh(): bool
    {
        return $this->autoRefresh;
    }
}
