<?php

namespace EvoAi\LaravelSdk;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\Services\A2AService;
use EvoAi\LaravelSdk\Services\AdminService;
use EvoAi\LaravelSdk\Services\AgentService;
use EvoAi\LaravelSdk\Services\ApiKeyService;
use EvoAi\LaravelSdk\Services\AuthService;
use EvoAi\LaravelSdk\Services\ChatService;
use EvoAi\LaravelSdk\Services\ClientService;
use EvoAi\LaravelSdk\Services\FolderService;
use EvoAi\LaravelSdk\Services\McpServerService;
use EvoAi\LaravelSdk\Services\SessionService;
use EvoAi\LaravelSdk\Services\ToolService;

final class EvoAiManager
{
    private EvoAiClientInterface $client;

    public function __construct(
        private readonly EvoAiClientInterface $baseClient,
    ) {
        $this->client = $this->baseClient;
    }

    public function auth(): AuthService
    {
        return once(fn () => new AuthService($this->client));
    }

    public function clients(): ClientService
    {
        return once(fn () => new ClientService($this->client));
    }

    public function agents(): AgentService
    {
        return once(fn () => new AgentService($this->client));
    }

    public function folders(): FolderService
    {
        return once(fn () => new FolderService($this->client));
    }

    public function apiKeys(): ApiKeyService
    {
        return once(fn () => new ApiKeyService($this->client));
    }

    public function mcpServers(): McpServerService
    {
        return once(fn () => new McpServerService($this->client));
    }

    public function tools(): ToolService
    {
        return once(fn () => new ToolService($this->client));
    }

    public function sessions(): SessionService
    {
        return once(fn () => new SessionService($this->client));
    }

    public function chat(): ChatService
    {
        return once(fn () => new ChatService($this->client));
    }

    public function a2a(): A2AService
    {
        return once(fn () => new A2AService($this->client));
    }

    public function admin(): AdminService
    {
        return once(fn () => new AdminService($this->client));
    }

    public function authenticate(
        string $email,
        #[\SensitiveParameter] string $password,
    ): self {
        $this->client->authenticate($email, $password);

        return $this;
    }

    public function withToken(#[\SensitiveParameter] string $token): self
    {
        $new = clone $this;
        $new->client = $this->client->withToken($token);

        return $new;
    }

    public function withApiKey(#[\SensitiveParameter] string $apiKey): self
    {
        $new = clone $this;
        $new->client = $this->client->withApiKey($apiKey);

        return $new;
    }

    public function forClient(string $clientId): self
    {
        $new = clone $this;
        $new->client = $this->client->withClientId($clientId);

        return $new;
    }

    public function getClient(): EvoAiClientInterface
    {
        return $this->client;
    }
}
