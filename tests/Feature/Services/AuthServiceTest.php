<?php

use EvoAi\LaravelSdk\DTOs\Auth\LoginData;
use EvoAi\LaravelSdk\DTOs\Auth\RegisterData;
use EvoAi\LaravelSdk\DTOs\Auth\TokenResponse;
use EvoAi\LaravelSdk\DTOs\Auth\UserResponse;
use EvoAi\LaravelSdk\Facades\EvoAi;
use Illuminate\Support\Facades\Http;

it('logs in and returns token response', function () {
    Http::fake([
        '*/api/v1/auth/login' => Http::response([
            'access_token' => 'fake-jwt-token',
            'token_type' => 'bearer',
        ]),
    ]);

    $response = EvoAi::auth()->login(new LoginData(
        email: 'user@example.com',
        password: 'password',
    ));

    expect($response)->toBeInstanceOf(TokenResponse::class)
        ->and($response->access_token)->toBe('fake-jwt-token')
        ->and($response->token_type)->toBe('bearer');
});

it('registers a user', function () {
    Http::fake([
        '*/api/v1/auth/register' => Http::response([
            'id' => 'uuid-1',
            'email' => 'new@example.com',
            'is_active' => true,
            'is_admin' => false,
            'client_id' => null,
            'email_verified' => false,
        ]),
    ]);

    $response = EvoAi::auth()->register(new RegisterData(
        email: 'new@example.com',
        password: 'password',
        name: 'New User',
    ));

    expect($response)->toBeInstanceOf(UserResponse::class)
        ->and($response->email)->toBe('new@example.com');
});

it('gets current user', function () {
    Http::fake([
        '*/api/v1/auth/me' => Http::response([
            'id' => 'uuid-1',
            'email' => 'me@example.com',
            'is_active' => true,
            'is_admin' => true,
            'client_id' => 'client-1',
            'email_verified' => true,
        ]),
    ]);

    $response = EvoAi::withToken('fake-token')->auth()->me();

    expect($response)->toBeInstanceOf(UserResponse::class)
        ->and($response->is_admin)->toBeTrue();
});
