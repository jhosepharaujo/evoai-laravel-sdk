<?php

use EvoAi\LaravelSdk\DTOs\Admin\AdminUserCreateData;
use EvoAi\LaravelSdk\DTOs\Admin\AuditLogData;
use EvoAi\LaravelSdk\DTOs\Admin\AuditLogFilters;
use EvoAi\LaravelSdk\DTOs\ApiKey\ApiKeyCreateData;
use EvoAi\LaravelSdk\DTOs\ApiKey\ApiKeyData;
use EvoAi\LaravelSdk\DTOs\ApiKey\ApiKeyUpdateData;
use EvoAi\LaravelSdk\DTOs\Chat\ChatRequestData;
use EvoAi\LaravelSdk\DTOs\Chat\ChatResponseData;
use EvoAi\LaravelSdk\DTOs\Chat\FileData;
use EvoAi\LaravelSdk\DTOs\Client\ClientCreateData;
use EvoAi\LaravelSdk\DTOs\Client\ClientData;
use EvoAi\LaravelSdk\DTOs\Folder\FolderCreateData;
use EvoAi\LaravelSdk\DTOs\Folder\FolderData;
use EvoAi\LaravelSdk\DTOs\McpServer\McpServerCreateData;
use EvoAi\LaravelSdk\DTOs\McpServer\McpServerData;
use EvoAi\LaravelSdk\DTOs\Session\SessionData;
use EvoAi\LaravelSdk\DTOs\Tool\ToolCreateData;
use EvoAi\LaravelSdk\DTOs\Tool\ToolData;

it('creates ClientCreateData from array', function () {
    $dto = ClientCreateData::from(['name' => 'Client', 'email' => 'c@test.com', 'password' => 'pass']);
    expect($dto->name)->toBe('Client')
        ->and($dto->toArray())->toHaveKeys(['name', 'email', 'password']);
});

it('creates ClientData from array', function () {
    $dto = ClientData::from(['id' => '1', 'name' => 'Client', 'email' => 'c@test.com', 'created_at' => '2024-01-01']);
    expect($dto->id)->toBe('1');
});

it('creates FolderCreateData from array', function () {
    $dto = FolderCreateData::from(['name' => 'Folder', 'client_id' => 'c-id']);
    expect($dto->name)->toBe('Folder')
        ->and($dto->description)->toBeNull();
});

it('creates FolderData from array', function () {
    $dto = FolderData::from(['id' => '1', 'client_id' => 'c', 'name' => 'F', 'description' => null, 'created_at' => '2024-01-01']);
    expect($dto->id)->toBe('1');
});

it('creates ApiKeyCreateData from array', function () {
    $dto = ApiKeyCreateData::from(['name' => 'Key', 'provider' => 'openai', 'client_id' => 'c', 'key_value' => 'sk-xxx']);
    expect($dto->provider)->toBe('openai')
        ->and($dto->key_value)->toBe('sk-xxx');
});

it('creates ApiKeyUpdateData with partial fields', function () {
    $dto = new ApiKeyUpdateData(name: 'New Name');
    expect($dto->toArray())->toBe(['name' => 'New Name']);
});

it('creates ApiKeyData from array', function () {
    $dto = ApiKeyData::from([
        'id' => '1', 'client_id' => 'c', 'name' => 'Key',
        'provider' => 'openai', 'is_active' => true, 'created_at' => '2024-01-01',
    ]);
    expect($dto->is_active)->toBeTrue();
});

it('creates McpServerCreateData from array', function () {
    $dto = McpServerCreateData::from(['name' => 'Server']);
    expect($dto->name)->toBe('Server')
        ->and($dto->config_type)->toBe('studio');
});

it('creates McpServerData from array', function () {
    $dto = McpServerData::from([
        'id' => '1', 'name' => 'S', 'config_type' => 'studio',
        'config_json' => [], 'environments' => [], 'type' => 'official', 'created_at' => '2024-01-01',
    ]);
    expect($dto->id)->toBe('1');
});

it('creates ToolCreateData from array', function () {
    $dto = ToolCreateData::from(['name' => 'Tool']);
    expect($dto->name)->toBe('Tool');
});

it('creates ToolData from array', function () {
    $dto = ToolData::from([
        'id' => '1', 'name' => 'T', 'description' => 'desc',
        'config_json' => [], 'environments' => [], 'created_at' => '2024-01-01',
    ]);
    expect($dto->id)->toBe('1');
});

it('creates SessionData from array', function () {
    $dto = SessionData::from(['id' => 's1', 'app_name' => 'app', 'user_id' => 'u1']);
    expect($dto->id)->toBe('s1')
        ->and($dto->state)->toBe([])
        ->and($dto->events)->toBe([])
        ->and($dto->last_update_time)->toBe(0.0);
});

it('creates ChatRequestData with files', function () {
    $dto = ChatRequestData::from([
        'message' => 'Hello',
        'files' => [
            ['filename' => 'test.txt', 'content_type' => 'text/plain', 'data' => 'base64data'],
        ],
    ]);
    expect($dto->message)->toBe('Hello')
        ->and($dto->files)->toHaveCount(1)
        ->and($dto->files[0])->toBeInstanceOf(FileData::class);
});

it('creates ChatRequestData without files', function () {
    $dto = new ChatRequestData(message: 'Hi');
    $array = $dto->toArray();
    expect($array)->toBe(['message' => 'Hi'])
        ->and($array)->not->toHaveKey('files');
});

it('creates ChatResponseData from array', function () {
    $dto = ChatResponseData::from([
        'response' => 'Hello!', 'message_history' => [],
        'status' => 'completed', 'timestamp' => '2024-01-01T00:00:00Z',
    ]);
    expect($dto->response)->toBe('Hello!');
});

it('creates AdminUserCreateData from array', function () {
    $dto = AdminUserCreateData::from(['email' => 'a@test.com', 'password' => 'p', 'name' => 'Admin']);
    expect($dto->email)->toBe('a@test.com');
});

it('creates AuditLogData from array', function () {
    $dto = AuditLogData::from([
        'id' => '1', 'action' => 'create', 'resource_type' => 'agent', 'created_at' => '2024-01-01',
    ]);
    expect($dto->action)->toBe('create');
});

it('creates AuditLogFilters and filters null values', function () {
    $dto = new AuditLogFilters(action: 'create', limit: 50);
    $array = $dto->toArray();
    expect($array)->toHaveKey('action')
        ->and($array)->toHaveKey('limit')
        ->and($array)->toHaveKey('skip')
        ->and($array)->not->toHaveKey('user_id');
});
