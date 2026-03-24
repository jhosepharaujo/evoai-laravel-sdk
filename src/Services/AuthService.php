<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Auth\ChangePasswordData;
use EvoAi\LaravelSdk\DTOs\Auth\LoginData;
use EvoAi\LaravelSdk\DTOs\Auth\MessageResponse;
use EvoAi\LaravelSdk\DTOs\Auth\RegisterData;
use EvoAi\LaravelSdk\DTOs\Auth\ResetPasswordData;
use EvoAi\LaravelSdk\DTOs\Auth\TokenResponse;
use EvoAi\LaravelSdk\DTOs\Auth\UserResponse;

final readonly class AuthService
{
    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function register(RegisterData $data): UserResponse
    {
        return UserResponse::from(
            $this->client->post('/auth/register', $data->toArray()),
        );
    }

    public function registerAdmin(RegisterData $data): UserResponse
    {
        return UserResponse::from(
            $this->client->post('/auth/register-admin', $data->toArray()),
        );
    }

    public function login(LoginData $data): TokenResponse
    {
        return TokenResponse::from(
            $this->client->post('/auth/login', $data->toArray()),
        );
    }

    public function verifyEmail(string $token): MessageResponse
    {
        return MessageResponse::from(
            $this->client->get("/auth/verify-email/{$token}"),
        );
    }

    public function resendVerification(string $email): MessageResponse
    {
        return MessageResponse::from(
            $this->client->post('/auth/resend-verification', ['email' => $email]),
        );
    }

    public function forgotPassword(string $email): MessageResponse
    {
        return MessageResponse::from(
            $this->client->post('/auth/forgot-password', ['email' => $email]),
        );
    }

    public function resetPassword(ResetPasswordData $data): MessageResponse
    {
        return MessageResponse::from(
            $this->client->post('/auth/reset-password', $data->toArray()),
        );
    }

    public function me(): UserResponse
    {
        return UserResponse::from(
            $this->client->post('/auth/me'),
        );
    }

    public function changePassword(ChangePasswordData $data): MessageResponse
    {
        return MessageResponse::from(
            $this->client->post('/auth/change-password', $data->toArray()),
        );
    }
}
