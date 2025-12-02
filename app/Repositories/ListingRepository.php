<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

    public function updateListing(Listing $listing, array $data): bool
    {
        return $listing->update($data);
    }

    public function deleteListing(Listing $listing): bool
    {
        return $listing->delete();
    }

    public function filter(array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['user', 'category', 'photos'])
            ->when(isset($filters['status']) && $filters['status'] !== 'all', function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->when(!isset($filters['status']) || $filters['status'] === 'available', function ($query) {
                return $query->where('status', 'available');
            })
            ->when(isset($filters['category_id']) && $filters['category_id'], function ($query) use ($filters) {
                return $query->where('category_id', $filters['category_id']);
            })
            ->when(isset($filters['city']) && $filters['city'], function ($query) use ($filters) {
                return $query->where('city', 'like', '%' . $filters['city'] . '%');
            })
            ->when(isset($filters['search']) && $filters['search'], function ($query) use ($filters) {
                return $query->where(function ($q) use ($filters) {
                    $q->where('title', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%');
                });
            });

        // Apply sorting
        switch ($filters['sort'] ?? 'newest') {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'upvotes':
                $query->orderBy('upvotes_count', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate($filters['per_page'] ?? 12);
    }

    public function getUserListings(int $userId): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)
            ->with(['category', 'photos'])
            ->latest()
            ->paginate(15);
    }
}
