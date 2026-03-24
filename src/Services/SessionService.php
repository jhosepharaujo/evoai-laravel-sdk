<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Session\SessionData;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class SessionService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    /** @return list<SessionData> */
    public function getClientSessions(string $clientId): array
    {
        $response = $this->client->get("/sessions/client/{$clientId}");

        return array_map(fn (array $item) => SessionData::from($item), $response);
    }

    /** @return list<SessionData> */
    public function getAgentSessions(string $agentId, int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get("/sessions/agent/{$agentId}", [
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => SessionData::from($item), $response);
    }

    public function get(string $sessionId): SessionData
    {
        return SessionData::from(
            $this->client->get("/sessions/{$sessionId}"),
        );
    }

    public function delete(string $sessionId): void
    {
        $this->client->delete("/sessions/{$sessionId}");
    }

    /** @return array<string, mixed> */
    public function getMessages(string $sessionId): array
    {
        return $this->client->get("/sessions/{$sessionId}/messages");
    }
}
