<?php

namespace App\Repositories\Contracts;

use App\Models\Listing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ListingRepositoryInterface
{
    public function findById(int $id): ?Listing;
    public function getAll(): Collection;
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Listing;
    public function updateListing(Listing $listing, array $data): bool;
    public function deleteListing(Listing $listing): bool;
    public function filter(array $filters): LengthAwarePaginator;
    public function getUserListings(int $userId): LengthAwarePaginator;
}
