<?php

namespace EvoAi\LaravelSdk\Contracts;

interface EvoAiClientInterface
{
    public function authenticate(string $email, #[\SensitiveParameter] string $password): static;

    public function withToken(#[\SensitiveParameter] string $token): static;

    public function withApiKey(#[\SensitiveParameter] string $apiKey): static;

    public function withClientId(string $clientId): static;

    /** @return array<string, mixed> */
    public function get(string $uri, array $query = []): array;

    /** @return array<string, mixed> */
    public function post(string $uri, array $data = []): array;

    /** @return array<string, mixed> */
    public function put(string $uri, array $data = []): array;

    public function delete(string $uri): void;

    /** @return array<string, mixed> */
    public function postMultipart(string $uri, array $data, array $files): array;
}
