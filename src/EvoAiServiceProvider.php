<?php

namespace EvoAi\LaravelSdk;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\Http\EvoAiClient;
use EvoAi\LaravelSdk\Support\TokenManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class EvoAiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/evoai.php', 'evoai');

        $this->app->singleton(EvoAiClientInterface::class, function (Application $app): EvoAiClient {
            $config = $app['config']['evoai'];

            $client = new EvoAiClient(
                baseUrl: $config['base_url'],
                apiPrefix: $config['api_prefix'],
                timeout: $config['timeout'],
                connectTimeout: $config['connect_timeout'],
                retryConfig: $config['retry'],
            );

            if ($config['api_key']) {
                $client = $client->withApiKey($config['api_key']);
            }

            if ($config['client_id']) {
                $client = $client->withClientId($config['client_id']);
            }

            return $client;
        });

        $this->app->singleton(TokenManager::class, function (Application $app): TokenManager {
            $config = $app['config']['evoai']['token'];

            return new TokenManager(
                cache: $app['cache']->store($config['cache_store']),
                cacheKey: $config['cache_key'],
                ttl: $config['ttl'],
                autoRefresh: $config['auto_refresh'],
            );
        });

        $this->app->singleton(EvoAiManager::class, function (Application $app): EvoAiManager {
            return new EvoAiManager(
                $app->make(EvoAiClientInterface::class),
            );
        });

        $this->app->alias(EvoAiManager::class, 'evoai');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/evoai.php' => config_path('evoai.php'),
            ], 'evoai-config');
        }
    }
}
