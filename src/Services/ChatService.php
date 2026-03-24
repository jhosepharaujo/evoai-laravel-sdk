<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Chat\ChatRequestData;
use EvoAi\LaravelSdk\DTOs\Chat\ChatResponseData;

final readonly class ChatService
{
    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function send(string $agentId, string $externalId, ChatRequestData $data): ChatResponseData
    {
        return ChatResponseData::from(
            $this->client->post("/chat/{$agentId}/{$externalId}", $data->toArray()),
        );
    }
}
