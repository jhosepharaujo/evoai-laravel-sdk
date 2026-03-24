<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\ApiKey\ApiKeyCreateData;
use EvoAi\LaravelSdk\DTOs\ApiKey\ApiKeyData;
use EvoAi\LaravelSdk\DTOs\ApiKey\ApiKeyUpdateData;
use EvoAi\LaravelSdk\Enums\SortDirection;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class ApiKeyService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function create(ApiKeyCreateData $data): ApiKeyData
    {
        return ApiKeyData::from(
            $this->client->post('/agents/apikeys/', $data->toArray()),
        );
    }

    /** @return list<ApiKeyData> */
    public function list(
        string $clientId,
        int $skip = 0,
        int $limit = self::DEFAULT_LIMIT,
        string $sortBy = 'name',
        SortDirection $sortDirection = SortDirection::Asc,
    ): array {
        $response = $this->client->get('/agents/apikeys/', [
            'client_id' => $clientId,
            'skip' => $skip,
            'limit' => $limit,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection->value,
        ]);

        return array_map(fn (array $item) => ApiKeyData::from($item), $response);
    }

    /** @return EvoAiPaginator<ApiKeyData> */
    public function paginate(
        string $clientId,
        int $page = 1,
        int $perPage = self::DEFAULT_LIMIT,
        string $sortBy = 'name',
        SortDirection $sortDirection = SortDirection::Asc,
    ): EvoAiPaginator {
        $skip = ($page - 1) * $perPage;
        $items = $this->list(
            clientId: $clientId,
            skip: $skip,
            limit: $perPage,
            sortBy: $sortBy,
            sortDirection: $sortDirection,
        );

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function get(string $keyId, string $clientId): ApiKeyData
    {
        return ApiKeyData::from(
            $this->client->get("/agents/apikeys/{$keyId}", ['client_id' => $clientId]),
        );
    }

    public function update(string $keyId, ApiKeyUpdateData $data, string $clientId): ApiKeyData
    {
        return ApiKeyData::from(
            $this->client->put("/agents/apikeys/{$keyId}", array_merge(
                $data->toArray(),
                ['client_id' => $clientId],
            )),
        );
    }

    public function delete(string $keyId, string $clientId): void
    {
        $this->client->delete("/agents/apikeys/{$keyId}?client_id={$clientId}");
    }
}
