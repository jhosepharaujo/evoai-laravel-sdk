<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Tool\ToolCreateData;
use EvoAi\LaravelSdk\DTOs\Tool\ToolData;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class ToolService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    public function create(ToolCreateData $data): ToolData
    {
        return ToolData::from(
            $this->client->post('/tools/', $data->toArray()),
        );
    }

    /** @return list<ToolData> */
    public function list(int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get('/tools/', [
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => ToolData::from($item), $response);
    }

    /** @return EvoAiPaginator<ToolData> */
    public function paginate(int $page = 1, int $perPage = self::DEFAULT_LIMIT): EvoAiPaginator
    {
        $skip = ($page - 1) * $perPage;
        $items = $this->list(skip: $skip, limit: $perPage);

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function get(string $toolId): ToolData
    {
        return ToolData::from(
            $this->client->get("/tools/{$toolId}"),
        );
    }

    public function update(string $toolId, ToolCreateData $data): ToolData
    {
        return ToolData::from(
            $this->client->put("/tools/{$toolId}", $data->toArray()),
        );
    }

    public function delete(string $toolId): void
    {
        $this->client->delete("/tools/{$toolId}");
    }
}
