<?php

namespace EvoAi\LaravelSdk\Services;

use EvoAi\LaravelSdk\Contracts\EvoAiClientInterface;
use EvoAi\LaravelSdk\DTOs\Admin\AdminUserCreateData;
use EvoAi\LaravelSdk\DTOs\Admin\AuditLogData;
use EvoAi\LaravelSdk\DTOs\Admin\AuditLogFilters;
use EvoAi\LaravelSdk\DTOs\Auth\UserResponse;
use EvoAi\LaravelSdk\Support\EvoAiPaginator;
use EvoAi\LaravelSdk\Traits\HasPagination;

final readonly class AdminService
{
    use HasPagination;

    public function __construct(
        private EvoAiClientInterface $client,
    ) {}

    /** @return list<AuditLogData> */
    public function getAuditLogs(AuditLogFilters $filters): array
    {
        $response = $this->client->get('/admin/audit-logs', $filters->toArray());

        return array_map(fn (array $item) => AuditLogData::from($item), $response);
    }

    /** @return list<UserResponse> */
    public function listUsers(int $skip = 0, int $limit = self::DEFAULT_LIMIT): array
    {
        $response = $this->client->get('/admin/users', [
            'skip' => $skip,
            'limit' => $limit,
        ]);

        return array_map(fn (array $item) => UserResponse::from($item), $response);
    }

    /** @return EvoAiPaginator<UserResponse> */
    public function paginateUsers(int $page = 1, int $perPage = self::DEFAULT_LIMIT): EvoAiPaginator
    {
        $skip = ($page - 1) * $perPage;
        $items = $this->listUsers(skip: $skip, limit: $perPage);

        return new EvoAiPaginator(items: $items, skip: $skip, limit: $perPage);
    }

    public function createUser(AdminUserCreateData $data): UserResponse
    {
        return UserResponse::from(
            $this->client->post('/admin/users', $data->toArray()),
        );
    }

    public function deactivateUser(string $userId): void
    {
        $this->client->delete("/admin/users/{$userId}");
    }
}
