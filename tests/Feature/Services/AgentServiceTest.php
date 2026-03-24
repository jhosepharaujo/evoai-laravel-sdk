<?php

use EvoAi\LaravelSdk\DTOs\Agent\AgentCreateData;
use EvoAi\LaravelSdk\DTOs\Agent\AgentData;
use EvoAi\LaravelSdk\DTOs\Agent\AgentUpdateData;
use EvoAi\LaravelSdk\Enums\AgentType;
use EvoAi\LaravelSdk\Facades\EvoAi;
use Illuminate\Support\Facades\Http;

it('creates an agent', function () {
    Http::fake([
        '*/api/v1/agents/' => Http::response([
            'id' => 'agent-uuid',
            'client_id' => 'client-uuid',
            'type' => 'llm',
            'name' => 'My Agent',
            'model' => 'gemini-2.0-flash',
            'created_at' => '2024-01-01T00:00:00Z',
        ]),
    ]);

    $agent = EvoAi::withToken('token')->agents()->create(new AgentCreateData(
        client_id: 'client-uuid',
        type: AgentType::LLM,
        name: 'My Agent',
        model: 'gemini-2.0-flash',
    ));

    expect($agent)->toBeInstanceOf(AgentData::class)
        ->and($agent->id)->toBe('agent-uuid')
        ->and($agent->type)->toBe(AgentType::LLM)
        ->and($agent->name)->toBe('My Agent');
});

it('lists agents for a client', function () {
    Http::fake([
        '*/api/v1/agents/*' => Http::response([
            [
                'id' => 'a1',
                'client_id' => 'c1',
                'type' => 'llm',
                'name' => 'Agent 1',
                'created_at' => '2024-01-01',
            ],
            [
                'id' => 'a2',
                'client_id' => 'c1',
                'type' => 'sequential',
                'name' => 'Agent 2',
                'created_at' => '2024-01-02',
            ],
        ]),
    ]);

    $agents = EvoAi::withToken('token')->agents()->list('c1');

    expect($agents)->toHaveCount(2)
        ->and($agents[0])->toBeInstanceOf(AgentData::class)
        ->and($agents[1]->type)->toBe(AgentType::Sequential);
});

it('updates an agent', function () {
    Http::fake([
        '*/api/v1/agents/agent-uuid' => Http::response([
            'id' => 'agent-uuid',
            'client_id' => 'client-uuid',
            'type' => 'llm',
            'name' => 'Updated Agent',
            'created_at' => '2024-01-01',
        ]),
    ]);

    $agent = EvoAi::withToken('token')->agents()->update(
        'agent-uuid',
        new AgentUpdateData(name: 'Updated Agent'),
    );

    expect($agent->name)->toBe('Updated Agent');
});

it('paginates agents', function () {
    Http::fake([
        '*/api/v1/agents/*' => Http::response(
            array_map(fn ($i) => [
                'id' => "a{$i}",
                'client_id' => 'c1',
                'type' => 'llm',
                'name' => "Agent {$i}",
                'created_at' => '2024-01-01',
            ], range(1, 20)),
        ),
    ]);

    $paginator = EvoAi::withToken('token')->agents()->paginate('c1', page: 1, perPage: 20);

    expect($paginator)->toHaveCount(20)
        ->and($paginator->currentPage())->toBe(1)
        ->and($paginator->hasMore())->toBeTrue();
});
