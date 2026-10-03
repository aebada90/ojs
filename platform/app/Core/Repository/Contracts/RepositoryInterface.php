<?php

namespace App\Core\Repository\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function find(int|string $id): ?Model;

    public function findOrFail(int|string $id): Model;

    /** @return Collection<int, Model> */
    public function all(): Collection;

    /** @param array<string, mixed> $data */
    public function create(array $data): Model;

    /** @param array<string, mixed> $data */
    public function update(Model $model, array $data): Model;

    public function delete(Model $model): bool;

    /** @param array<string, mixed> $filters */
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator;
}
