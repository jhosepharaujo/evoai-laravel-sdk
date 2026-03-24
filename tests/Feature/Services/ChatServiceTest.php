<?php

use EvoAi\LaravelSdk\DTOs\Chat\ChatRequestData;
use EvoAi\LaravelSdk\DTOs\Chat\ChatResponseData;
use EvoAi\LaravelSdk\Facades\EvoAi;
use Illuminate\Support\Facades\Http;

it('sends a chat message', function () {
    Http::fake([
        '*/api/v1/chat/agent-1/ext-1' => Http::response([
            'response' => 'Hello! How can I help?',
            'message_history' => [
                ['role' => 'user', 'content' => 'Hello!'],
                ['role' => 'assistant', 'content' => 'Hello! How can I help?'],
            ],
            'status' => 'completed',
            'timestamp' => '2024-01-01T00:00:00Z',
        ]),
    ]);

    $response = EvoAi::withToken('token')->chat()->send(
        agentId: 'agent-1',
        externalId: 'ext-1',
        data: new ChatRequestData(message: 'Hello!'),
    );

    expect($response)->toBeInstanceOf(ChatResponseData::class)
        ->and($response->response)->toBe('Hello! How can I help?')
        ->and($response->status)->toBe('completed')
        ->and($response->message_history)->toHaveCount(2);
});
