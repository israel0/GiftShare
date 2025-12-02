<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(array $columns = ['*']): Collection;
    public function find($id, array $columns = ['*']);
    public function findBy(array $criteria, array $columns = ['*']);
    public function create(array $data);
    public function update($id, array $data): bool;
    public function delete($id): bool;
    public function paginate($perPage = 15, array $columns = ['*']);
}
