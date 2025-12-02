<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Listing;
use App\Repositories\Contracts\ListingRepositoryInterface;

class FilterListings extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $category = null;
    public string $city = '';
    public string $status = 'available';
    public string $sort = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
        'city' => ['except' => ''],
        'status' => ['except' => 'available'],
        'sort' => ['except' => 'newest'],
    ];

    public function mount()
    {
        $this->category = request()->input('category', null);
        $this->city = request()->input('city', '');
        $this->status = request()->input('status', 'available');
        $this->sort = request()->input('sort', 'newest');
    }

    public function updating($property, $value)
    {
        if (in_array($property, ['search', 'category', 'city', 'status', 'sort'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'city', 'status']);
        $this->resetPage();
    }

    public function render(ListingRepositoryInterface $listingRepository)
    {
        $filters = [
            'search' => $this->search,
            'category_id' => $this->category,
            'city' => $this->city,
            'status' => $this->status,
            'sort' => $this->sort,
            'per_page' => 12,
        ];

        $listings = $listingRepository->filter($filters);
        $categories = Category::all();
        $uniqueCities = Listing::distinct('city')->pluck('city');

        return view('livewire.filter-listings', [
            'listings' => $listings,
            'categories' => $categories,
            'cities' => $uniqueCities,
        ]);
    }
}
