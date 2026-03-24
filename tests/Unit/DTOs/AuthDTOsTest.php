<?php

use EvoAi\LaravelSdk\DTOs\Auth\ChangePasswordData;
use EvoAi\LaravelSdk\DTOs\Auth\ForgotPasswordData;
use EvoAi\LaravelSdk\DTOs\Auth\LoginData;
use EvoAi\LaravelSdk\DTOs\Auth\MessageResponse;
use EvoAi\LaravelSdk\DTOs\Auth\RegisterData;
use EvoAi\LaravelSdk\DTOs\Auth\ResetPasswordData;
use EvoAi\LaravelSdk\DTOs\Auth\TokenResponse;
use EvoAi\LaravelSdk\DTOs\Auth\UserResponse;

it('creates LoginData from array and converts back', function () {
    $data = ['email' => 'test@example.com', 'password' => 'secret'];
    $dto = LoginData::from($data);

    expect($dto->email)->toBe('test@example.com')
        ->and($dto->password)->toBe('secret')
        ->and($dto->toArray())->toBe($data);
});

it('creates RegisterData from array and converts back', function () {
    $data = ['email' => 'test@example.com', 'password' => 'secret', 'name' => 'Test User'];
    $dto = RegisterData::from($data);

    expect($dto->email)->toBe('test@example.com')
        ->and($dto->name)->toBe('Test User')
        ->and($dto->toArray())->toBe($data);
});

it('creates ForgotPasswordData from array', function () {
    $dto = ForgotPasswordData::from(['email' => 'test@example.com']);

    expect($dto->email)->toBe('test@example.com')
        ->and($dto->toArray())->toBe(['email' => 'test@example.com']);
});

it('creates ResetPasswordData from array', function () {
    $data = ['token' => 'abc123', 'new_password' => 'newsecret'];
    $dto = ResetPasswordData::from($data);

    expect($dto->token)->toBe('abc123')
        ->and($dto->new_password)->toBe('newsecret')
        ->and($dto->toArray())->toBe($data);
});

it('creates ChangePasswordData from array', function () {
    $data = ['current_password' => 'old', 'new_password' => 'new'];
    $dto = ChangePasswordData::from($data);

    expect($dto->current_password)->toBe('old')
        ->and($dto->new_password)->toBe('new')
        ->and($dto->toArray())->toBe($data);
});

it('creates TokenResponse from array', function () {
    $data = ['access_token' => 'jwt-token', 'token_type' => 'bearer'];
    $dto = TokenResponse::from($data);

    expect($dto->access_token)->toBe('jwt-token')
        ->and($dto->token_type)->toBe('bearer')
        ->and($dto->toArray())->toBe($data);
});

it('creates UserResponse from array', function () {
    $data = [
        'id' => 'uuid-1',
        'email' => 'test@example.com',
        'is_active' => true,
        'is_admin' => false,
        'client_id' => 'client-uuid',
        'email_verified' => true,
        'created_at' => '2024-01-01T00:00:00Z',
    ];
    $dto = UserResponse::from($data);

    expect($dto->id)->toBe('uuid-1')
        ->and($dto->email)->toBe('test@example.com')
        ->and($dto->is_active)->toBeTrue()
        ->and($dto->is_admin)->toBeFalse()
        ->and($dto->client_id)->toBe('client-uuid')
        ->and($dto->email_verified)->toBeTrue();
});

it('creates MessageResponse from array', function () {
    $dto = MessageResponse::from(['message' => 'Success']);

    expect($dto->message)->toBe('Success')
        ->and($dto->toArray())->toBe(['message' => 'Success']);
});

it('DTOs serialize to JSON', function () {
    $dto = LoginData::from(['email' => 'test@example.com', 'password' => 'secret']);

    expect($dto->toJson())->toBe('{"email":"test@example.com","password":"secret"}')
        ->and(json_encode($dto))->toBe('{"email":"test@example.com","password":"secret"}');
});
