<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Agent\AgentData;
use EvoAi\LaravelSdk\DTOs\Folder\FolderCreateData;
use EvoAi\LaravelSdk\DTOs\Folder\FolderData;
use EvoAi\LaravelSdk\DTOs\Folder\FolderUpdateData;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class FolderService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function create(FolderCreateData $data): FolderData
    {
        return FolderData::from(
            $this->client->post('/agents/folders/', $data->toArray()),
        );
    }

    /** @return list<FolderData> */
    public function list(string $clientId, int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get('/agents/folders/', [
            'client_id' => $clientId,
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => FolderData::from($item), $response);
    }

    /** @return EvoAiPaginator<FolderData> */
    public function paginate(string $clientId, int $page = 1, int $perPage = self::DEFAULT_LIMIT): EvoAiPaginator
    {
        $skip = ($page - 1) * $perPage;
        $items = $this->list(clientId: $clientId, skip: $skip, limit: $perPage);

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function get(string $folderId, string $clientId): FolderData
    {
        return FolderData::from(
            $this->client->get("/agents/folders/{$folderId}", ['client_id' => $clientId]),
        );
    }

    public function update(string $folderId, FolderUpdateData $data, string $clientId): FolderData
    {
        return FolderData::from(
            $this->client->put("/agents/folders/{$folderId}", array_merge(
                $data->toArray(),
                ['client_id' => $clientId],
            )),
        );
    }

    public function delete(string $folderId, string $clientId): void
    {
        $this->client->delete("/agents/folders/{$folderId}?client_id={$clientId}");
    }

    /** @return list<AgentData> */
    public function listAgents(string $folderId, string $clientId, int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get("/agents/folders/{$folderId}/agents", [
            'client_id' => $clientId,
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => AgentData::from($item), $response);
    }
}
