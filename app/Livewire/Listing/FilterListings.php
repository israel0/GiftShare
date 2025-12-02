<?php

namespace App\Livewire\Listing;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Models\Category;

class FilterListings extends Component
{
    use WithPagination;

    public ?string $search = '';
    public ?int $categoryId = null;
    public ?string $city = '';
    public ?string $status = 'available';
    public string $sortBy = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryId' => ['except' => null],
        'city' => ['except' => ''],
        'status' => ['except' => 'available'],
        'sortBy' => ['except' => 'newest'],
    ];

    public function render(ListingRepositoryInterface $listingRepository)
    {
        $filters = [
            'search' => $this->search,
            'category_id' => $this->categoryId,
            'city' => $this->city,
            'status' => $this->status,
            'sort' => $this->sortBy === 'most_upvoted' ? '-upvotes_count' : '-created_at',
            'per_page' => 12,
        ];

        $listings = $listingRepository->filter($filters);
        $categories = Category::all();

        return view('livewire.listing.filter-listings', [
            'listings' => $listings,
            'categories' => $categories,
        ]);
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'categoryId', 'city', 'status', 'sortBy'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'categoryId', 'city', 'status']);
        $this->resetPage();
    }
}
