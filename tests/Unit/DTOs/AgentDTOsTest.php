<?php

use EvoAi\LaravelSdk\DTOs\Agent\AgentCreateData;
use EvoAi\LaravelSdk\DTOs\Agent\AgentData;
use EvoAi\LaravelSdk\DTOs\Agent\AgentUpdateData;
use EvoAi\LaravelSdk\Enums\AgentType;

it('creates AgentCreateData from array', function () {
    $data = [
        'client_id' => 'client-uuid',
        'type' => 'llm',
        'name' => 'My Agent',
        'model' => 'gemini-2.0-flash',
    ];

    $dto = AgentCreateData::from($data);

    expect($dto->client_id)->toBe('client-uuid')
        ->and($dto->type)->toBe(AgentType::LLM)
        ->and($dto->name)->toBe('My Agent')
        ->and($dto->model)->toBe('gemini-2.0-flash')
        ->and($dto->description)->toBeNull();
});

it('filters null values in AgentCreateData toArray', function () {
    $dto = new AgentCreateData(
        client_id: 'client-uuid',
        type: AgentType::LLM,
        name: 'Agent',
    );

    $array = $dto->toArray();

    expect($array)->toHaveKeys(['client_id', 'type', 'name'])
        ->and($array)->not->toHaveKey('description')
        ->and($array)->not->toHaveKey('model');
});

it('creates AgentUpdateData with only changed fields', function () {
    $dto = new AgentUpdateData(name: 'Updated Name');

    expect($dto->toArray())->toBe(['name' => 'Updated Name']);
});

it('creates AgentData from API response', function () {
    $data = [
        'id' => 'agent-uuid',
        'client_id' => 'client-uuid',
        'type' => 'sequential',
        'name' => 'Sequential Agent',
        'created_at' => '2024-01-01T00:00:00Z',
    ];

    $dto = AgentData::from($data);

    expect($dto->id)->toBe('agent-uuid')
        ->and($dto->type)->toBe(AgentType::Sequential)
        ->and($dto->name)->toBe('Sequential Agent')
        ->and($dto->created_at)->toBe('2024-01-01T00:00:00Z');
});

it('accepts AgentType enum in from()', function () {
    $dto = AgentCreateData::from([
        'client_id' => 'c',
        'type' => AgentType::A2A,
    ]);

    expect($dto->type)->toBe(AgentType::A2A);
});
