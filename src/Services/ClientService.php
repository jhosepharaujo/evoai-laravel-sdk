<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Auth\TokenResponse;
use EvoAi\LaravelSdk\DTOs\Client\ClientCreateData;
use EvoAi\LaravelSdk\DTOs\Client\ClientData;
use EvoAi\LaravelSdk\DTOs\Client\ClientUpdateData;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class ClientService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function create(ClientCreateData $data): ClientData
    {
        return ClientData::from(
            $this->client->post('/clients/', $data->toArray()),
        );
    }

    /** @return list<ClientData> */
    public function list(int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get('/clients/', [
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => ClientData::from($item), $response);
    }

    /** @return EvoAiPaginator<ClientData> */
    public function paginate(int $page = 1, int $perPage = self::DEFAULT_LIMIT): EvoAiPaginator
    {
        $skip = ($page - 1) * $perPage;
        $items = $this->list(skip: $skip, limit: $perPage);

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function get(string $clientId): ClientData
    {
        return ClientData::from(
            $this->client->get("/clients/{$clientId}"),
        );
    }

    public function update(string $clientId, ClientUpdateData $data): ClientData
    {
        return ClientData::from(
            $this->client->put("/clients/{$clientId}", $data->toArray()),
        );
    }

    public function delete(string $clientId): void
    {
        $this->client->delete("/clients/{$clientId}");
    }

    public function impersonate(string $clientId): TokenResponse
    {
        return TokenResponse::from(
            $this->client->post("/clients/{$clientId}/impersonate"),
        );
    }
}
