<?php

namespace EvoAi\LaravelSdk\Http\Middleware;

use Illuminate\Support\Facades\Log;

final readonly class LoggingMiddleware
{
    public function __construct(
        private bool $enabled,
        private ?string $channel,
        private array $redactKeys,
    ) {}

    public function __invoke(callable $handler): callable
    {
        return function (string $method, string $url, array $options) use ($handler) {
            if (! $this->enabled) {
                return $handler($method, $url, $options);
            }

            $logger = $this->channel ? Log::channel($this->channel) : Log::getFacadeRoot();

            $logger->debug('EvoAI API Request', [
                'method' => $method,
                'url' => $url,
                'payload' => $this->redact($options['json'] ?? $options['form_params'] ?? []),
            ]);

            $start = hrtime(true);

            $result = $handler($method, $url, $options);

            $durationMs = (hrtime(true) - $start) / 1e6;

            $logger->debug('EvoAI API Response', [
                'method' => $method,
                'url' => $url,
                'duration_ms' => round($durationMs, 2),
            ]);

            return $result;
        };
    }

    private function redact(array $data): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->redactKeys, true)) {
                $result[$key] = '********';
            } elseif (is_array($value)) {
                $result[$key] = $this->redact($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
