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

    
}
