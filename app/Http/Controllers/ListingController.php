<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Services\ListingService;
use App\DTO\ListingDTO;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function __construct(
        protected ListingService $listingService
    ) {}

    public function index(): View
    {
        return view('listings.index');
    }

    public function show(Listing $listing): View
    {
        $listing->load(['user', 'category', 'photos', 'comments.user']);
        return view('listings.show', compact('listing'));
    }

    public function create(): View
    {
        return view('listings.create');
    }

    public function store(StoreListingRequest $request): RedirectResponse
    {
        $dto = ListingDTO::fromRequest($request->validated(), $request->file('photos'));
        $listing = $this->listingService->createListing($dto, auth()->id());

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing created successfully!');
    }

    public function edit(Listing $listing): View
    {
        $this->authorize('update', $listing);
        return view('listings.edit', compact('listing'));
    }

    public function update(UpdateListingRequest $request, Listing $listing): RedirectResponse
    {
        $this->authorize('update', $listing);

        $dto = ListingDTO::fromRequest($request->validated(), $request->file('photos'));
        $this->listingService->updateListing($listing, $dto);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $this->authorize('delete', $listing);
        $this->listingService->deleteListing($listing);

        return redirect()->route('listings.index')
            ->with('success', 'Listing deleted successfully!');
    }

    public function markAsGifted(Listing $listing): RedirectResponse
    {
        $this->authorize('update', $listing);
        $this->listingService->markAsGifted($listing);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing marked as gifted!');
    }

    public function myListings(): View
    {
        $listings = auth()->user()->listings()
            ->with(['category', 'photos'])
            ->latest()
            ->paginate(15);

        return view('listings.my-listings', compact('listings'));
    }
}
