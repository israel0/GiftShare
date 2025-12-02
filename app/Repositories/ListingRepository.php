<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ListingRepository extends EloquentRepository implements ListingRepositoryInterface
{
    public function __construct(Listing $model)
    {
        parent::__construct($model);
    }

    public function findById(int $id): ?Listing
    {
        return $this->model->with(['user', 'category', 'photos'])->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->with(['user', 'category'])->get();
    }

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['user', 'category', 'photos'])
            ->available()
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Listing
    {
        return $this->model->create($data);
    }

    public function update(Listing $listing, array $data): bool
    {
        return $listing->update($data);
    }

    public function delete(Listing $listing): bool
    {
        return $listing->delete();
    }

    public function filter(array $filters): LengthAwarePaginator
    {
        $query = QueryBuilder::for(Listing::class)
            ->allowedFilters([
                'category_id',
                'city',
                'status',
                AllowedFilter::scope('search'),
            ])
            ->allowedSorts(['created_at', 'upvotes_count'])
            ->defaultSort('-created_at');

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['city'])) {
            $query->where('city', 'like', "%{$filters['city']}%");
        }

        if (!isset($filters['status'])) {
            $query->available();
        }

        return $query->with(['user', 'category', 'photos'])
            ->paginate($filters['per_page'] ?? 15)
            ->appends($filters);
    }

    public function getUserListings(int $userId): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)
            ->with(['category', 'photos'])
            ->latest()
            ->paginate(15);
    }
}
