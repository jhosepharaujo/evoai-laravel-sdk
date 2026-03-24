<?php

use EvoAi\LaravelSdk\DTOs\Client\ClientCreateData;
use EvoAi\LaravelSdk\DTOs\Client\ClientData;
use EvoAi\LaravelSdk\Facades\EvoAi;
use Illuminate\Support\Facades\Http;

it('creates a client', function () {
    Http::fake([
        '*/api/v1/clients/' => Http::response([
            'id' => 'client-uuid',
            'name' => 'Test Client',
            'email' => 'client@test.com',
            'created_at' => '2024-01-01T00:00:00Z',
        ]),
    ]);

    $client = EvoAi::withToken('token')->clients()->create(new ClientCreateData(
        name: 'Test Client',
        email: 'client@test.com',
        password: 'password',
    ));

    expect($client)->toBeInstanceOf(ClientData::class)
        ->and($client->name)->toBe('Test Client');
});

it('lists clients', function () {
    Http::fake([
        '*/api/v1/clients/*' => Http::response([
            ['id' => '1', 'name' => 'Client 1', 'email' => 'c1@test.com', 'created_at' => '2024-01-01'],
            ['id' => '2', 'name' => 'Client 2', 'email' => 'c2@test.com', 'created_at' => '2024-01-02'],
        ]),
    ]);

    $clients = EvoAi::withToken('token')->clients()->list();

    expect($clients)->toHaveCount(2)
        ->and($clients[0])->toBeInstanceOf(ClientData::class);
});
