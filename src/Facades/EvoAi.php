<?php

namespace EvoAi\LaravelSdk\Facades;

use EvoAi\LaravelSdk\EvoAiManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \EvoAi\LaravelSdk\Services\AuthService auth()
 * @method static \EvoAi\LaravelSdk\Services\AgentService agents()
 * @method static \EvoAi\LaravelSdk\Services\ClientService clients()
 * @method static \EvoAi\LaravelSdk\Services\FolderService folders()
 * @method static \EvoAi\LaravelSdk\Services\ApiKeyService apiKeys()
 * @method static \EvoAi\LaravelSdk\Services\McpServerService mcpServers()
 * @method static \EvoAi\LaravelSdk\Services\ToolService tools()
 * @method static \EvoAi\LaravelSdk\Services\SessionService sessions()
 * @method static \EvoAi\LaravelSdk\Services\ChatService chat()
 * @method static \EvoAi\LaravelSdk\Services\A2AService a2a()
 * @method static \EvoAi\LaravelSdk\Services\AdminService admin()
 * @method static \EvoAi\LaravelSdk\EvoAiManager authenticate(string $email, string $password)
 * @method static \EvoAi\LaravelSdk\EvoAiManager withToken(string $token)
 * @method static \EvoAi\LaravelSdk\EvoAiManager withApiKey(string $apiKey)
 * @method static \EvoAi\LaravelSdk\EvoAiManager forClient(string $clientId)
 *
 * @see EvoAiManager
 */
final class EvoAi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'evoai';
    }
}
