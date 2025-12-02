<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\ListingRepositoryInterface;

class MyListings extends Component
{
    use WithPagination;

    public string $status = 'all';

    public function updatingStatus($value)
    {
        $this->resetPage();
    }

    public function render(ListingRepositoryInterface $listingRepository)
    {
        $userId = auth()->id();
        $listings = $listingRepository->getUserListings($userId);

        // Filter by status if needed
        if ($this->status !== 'all') {
            $listings = $listings->where('status', $this->status);
        }

        return view('livewire.my-listings', [
            'listings' => $listings->paginate(12),
        ]);
    }
}
