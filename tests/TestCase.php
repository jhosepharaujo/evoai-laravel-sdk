<?php

namespace EvoAi\LaravelSdk\Tests;

use EvoAi\LaravelSdk\EvoAiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            EvoAiServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('evoai.base_url', 'https://api.test.evoai.com');
        $app['config']->set('evoai.api_prefix', '/api/v1');
    }
}
