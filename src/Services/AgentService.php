<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Agent\AgentCreateData;
use EvoAi\LaravelSdk\DTOs\Agent\AgentData;
use EvoAi\LaravelSdk\DTOs\Agent\AgentUpdateData;
use EvoAi\LaravelSdk\Enums\SortDirection;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class AgentService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function create(AgentCreateData $data): AgentData
    {
        return AgentData::from(
            $this->client->post('/agents/', $data->toArray()),
        );
    }

    /** @return list<AgentData> */
    public function list(
        string $clientId,
        int $skip = 0,
        int $limit = self::DEFAULT_LIMIT,
        ?string $folderId = null,
        string $sortBy = 'name',
        SortDirection $sortDirection = SortDirection::Asc,
    ): array {
        $query = array_filter([
            'client_id' => $clientId,
            'skip' => $skip,
            'limit' => $limit,
            'folder_id' => $folderId,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection->value,
        ], fn (mixed $v): bool => $v !== null);

        $response = $this->client->get('/agents/', $query);

        return array_map(fn (array $item) => AgentData::from($item), $response);
    }

    /** @return EvoAiPaginator<AgentData> */
    public function paginate(
        string $clientId,
        int $page = 1,
        int $perPage = self::DEFAULT_LIMIT,
        ?string $folderId = null,
        string $sortBy = 'name',
        SortDirection $sortDirection = SortDirection::Asc,
    ): EvoAiPaginator {
        $skip = ($page - 1) * $perPage;
        $items = $this->list(
            clientId: $clientId,
            skip: $skip,
            limit: $perPage,
            folderId: $folderId,
            sortBy: $sortBy,
            sortDirection: $sortDirection,
        );

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function get(string $agentId, string $clientId): AgentData
    {
        return AgentData::from(
            $this->client->get("/agents/{$agentId}", ['client_id' => $clientId]),
        );
    }

    public function update(string $agentId, AgentUpdateData|array $data): AgentData
    {
        $payload = $data instanceof AgentUpdateData ? $data->toArray() : $data;

        return AgentData::from(
            $this->client->put("/agents/{$agentId}", $payload),
        );
    }

    public function delete(string $agentId): void
    {
        $this->client->delete("/agents/{$agentId}");
    }

    /** @return array{api_key: string} */
    public function share(string $agentId, string $clientId): array
    {
        return $this->client->post("/agents/{$agentId}/share", [
            'client_id' => $clientId,
        ]);
    }

    public function getShared(string $agentId): AgentData
    {
        return AgentData::from(
            $this->client->get("/agents/{$agentId}/shared"),
        );
    }

    public function assignToFolder(string $agentId, ?string $folderId, string $clientId): AgentData
    {
        return AgentData::from(
            $this->client->put("/agents/{$agentId}/folder", [
                'folder_id' => $folderId,
                'client_id' => $clientId,
            ]),
        );
    }

    /** @return list<AgentData> */
    public function import(string $filePath, string $clientId, ?string $folderId = null): array
    {
        $response = $this->client->postMultipart('/agents/import', array_filter([
            'client_id' => $clientId,
            'folder_id' => $folderId,
        ], fn (mixed $v): bool => $v !== null), [
            'file' => [
                'contents' => fopen($filePath, 'r'),
                'filename' => basename($filePath),
            ],
        ]);

        return array_map(fn (array $item) => AgentData::from($item), $response);
    }
}
