<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->get($columns);
    }

    public function find($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function findBy(array $criteria, array $columns = ['*'])
    {
        $query = $this->model;

        foreach ($criteria as $field => $value) {
            $query = $query->where($field, $value);
        }

        return $query->get($columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        $record = $this->find($id);
        if (!$record) {
            return false;
        }

        return $record->update($data);
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    public function paginate($perPage = 15, array $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }
}
