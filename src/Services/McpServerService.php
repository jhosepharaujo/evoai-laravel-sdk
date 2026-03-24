<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\McpServer\McpServerCreateData;
use EvoAi\LaravelSdk\DTOs\McpServer\McpServerData;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class McpServerService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function create(McpServerCreateData $data): McpServerData
    {
        return McpServerData::from(
            $this->client->post('/mcp-servers/', $data->toArray()),
        );
    }

    /** @return list<McpServerData> */
    public function list(int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get('/mcp-servers/', [
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => McpServerData::from($item), $response);
    }

    /** @return EvoAiPaginator<McpServerData> */
    public function paginate(int $page = 1, int $perPage = self::DEFAULT_LIMIT): EvoAiPaginator
    {
        $skip = ($page - 1) * $perPage;
        $items = $this->list(skip: $skip, limit: $perPage);

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function get(string $serverId): McpServerData
    {
        return McpServerData::from(
            $this->client->get("/mcp-servers/{$serverId}"),
        );
    }

    public function update(string $serverId, McpServerCreateData $data): McpServerData
    {
        return McpServerData::from(
            $this->client->put("/mcp-servers/{$serverId}", $data->toArray()),
        );
    }

    public function delete(string $serverId): void
    {
        $this->client->delete("/mcp-servers/{$serverId}");
    }
}
