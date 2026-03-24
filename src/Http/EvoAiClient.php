<?php

namespace EvoAi\LaravelSdk\Http;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\Exceptions\AuthenticationException;
use EvoAi\LaravelSdk\Exceptions\EvoAiException;
use EvoAi\LaravelSdk\Exceptions\ForbiddenException;
use EvoAi\LaravelSdk\Exceptions\NotFoundException;
use EvoAi\LaravelSdk\Exceptions\ValidationException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class EvoAiClient implements EvoAiClientInterface
{
    private ?string $token = null;

    private ?string $apiKey = null;

    private ?string $clientId = null;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiPrefix,
        private readonly int $timeout,
        private readonly int $connectTimeout,
        private readonly array $retryConfig,
    ) {}

    public function authenticate(
        string $email,
        #[\SensitiveParameter] string $password,
    ): static {
        $response = $this->buildRequest()
            ->post($this->url('/auth/login'), [
                'email' => $email,
                'password' => $password,
            ]);

        $data = $this->handleResponse($response);
        $this->token = $data['access_token'];

        return $this;
    }

    public function withToken(#[\SensitiveParameter] string $token): static
    {
        $clone = clone $this;
        $clone->token = $token;

        return $clone;
    }

    public function withApiKey(#[\SensitiveParameter] string $apiKey): static
    {
        $clone = clone $this;
        $clone->apiKey = $apiKey;

        return $clone;
    }

    public function withClientId(string $clientId): static
    {
        $clone = clone $this;
        $clone->clientId = $clientId;

        return $clone;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /** @return array<string, mixed> */
    public function get(string $uri, array $query = []): array
    {
        $response = $this->buildRequest()->get($this->url($uri), $query);

        return $this->handleResponse($response);
    }

    /** @return array<string, mixed> */
    public function post(string $uri, array $data = []): array
    {
        $response = $this->buildRequest()->post($this->url($uri), $data);

        return $this->handleResponse($response);
    }

    /** @return array<string, mixed> */
    public function put(string $uri, array $data = []): array
    {
        $response = $this->buildRequest()->put($this->url($uri), $data);

        return $this->handleResponse($response);
    }

    public function delete(string $uri): void
    {
        $response = $this->buildRequest()->delete($this->url($uri));

        if (! $response->successful()) {
            $this->handleResponse($response);
        }
    }

    /** @return array<string, mixed> */
    public function postMultipart(string $uri, array $data, array $files): array
    {
        $request = $this->buildRequest()->asMultipart();

        foreach ($data as $key => $value) {
            $request->attach($key, $value);
        }

        foreach ($files as $name => $file) {
            $request->attach($name, $file['contents'], $file['filename'], $file['headers'] ?? []);
        }

        $response = $request->post($this->url($uri));

        return $this->handleResponse($response);
    }

    private function url(string $uri): string
    {
        return $this->baseUrl . $this->apiPrefix . $uri;
    }

    private function buildRequest(): PendingRequest
    {
        $request = Http::timeout($this->timeout)
            ->connectTimeout($this->connectTimeout)
            ->retry(
                times: $this->retryConfig['times'],
                sleepMilliseconds: $this->retryConfig['sleep'],
                when: fn (\Exception $exception): bool => $exception instanceof \Illuminate\Http\Client\RequestException
                    && in_array($exception->response->status(), $this->retryConfig['when'], true),
                throw: false,
            )
            ->acceptJson()
            ->contentType('application/json');

        if ($this->token !== null) {
            $request->withToken($this->token);
        }

        if ($this->apiKey !== null) {
            $request->withHeaders(['x-api-key' => $this->apiKey]);
        }

        if ($this->clientId !== null) {
            $request->withHeaders(['x-client-id' => $this->clientId]);
        }

        return $request;
    }

    /** @return array<string, mixed> */
    private function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return $response->json() ?? [];
        }

        throw match ($response->status()) {
            401 => new AuthenticationException($response),
            403 => new ForbiddenException($response),
            404 => new NotFoundException($response),
            422 => new ValidationException($response),
            default => new EvoAiException($response),
        };
    }
}
