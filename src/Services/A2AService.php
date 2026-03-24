<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class A2AService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    /** @return array<string, mixed> */
    public function sendMessage(
        string $agentId,
        array $jsonRpcPayload,
        #[\SensitiveParameter] ?string $apiKey = null,
    ): array {
        $client = $apiKey !== null ? $this->client->withApiKey($apiKey) : $this->client;

        return $client->post("/a2a/{$agentId}", $jsonRpcPayload);
    }

    /** @return array<string, mixed> */
    public function getAgentCard(string $agentId): array
    {
        return $this->client->get("/a2a/{$agentId}/.well-known/agent.json");
    }

    /** @return array<string, mixed> */
    public function healthCheck(): array
    {
        return $this->client->get('/a2a/health');
    }

    /** @return array<string, mixed> */
    public function listSessions(
        string $agentId,
        string $externalId,
        #[\SensitiveParameter] ?string $apiKey = null,
    ): array {
        $client = $apiKey !== null ? $this->client->withApiKey($apiKey) : $this->client;

        return $client->get("/a2a/{$agentId}/sessions", [
            'external_id' => $externalId,
        ]);
    }

    /** @return array<string, mixed> */
    public function getSessionHistory(
        string $agentId,
        string $sessionId,
        int $limit = 50,
        #[\SensitiveParameter] ?string $apiKey = null,
    ): array {
        $client = $apiKey !== null ? $this->client->withApiKey($apiKey) : $this->client;

        return $client->get("/a2a/{$agentId}/sessions/{$sessionId}/history", [
            'limit' => $limit,
        ]);
    }

    /** @return array<string, mixed> */
    public function getConversationHistory(
        string $agentId,
        #[\SensitiveParameter] ?string $apiKey = null,
    ): array {
        $client = $apiKey !== null ? $this->client->withApiKey($apiKey) : $this->client;

        return $client->post("/a2a/{$agentId}/conversation/history");
    }
}
