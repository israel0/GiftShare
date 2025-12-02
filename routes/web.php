<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Livewire\Listing\{FilterListings,MyListings};

Route::get('/', function () {
    return redirect()->route('listings.index');
});

Route::get('/listings', FilterListings::class)
    ->name('listings.index');

Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])
    ->name('listings.show');

Route::view('about', 'about')->name('about');
Route::view('terms', 'terms')->name('terms');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    Route::get('/my-listings', MyListings::class)
        ->name('listings.my');

    Route::get('/listings/create', [ListingController::class, 'create'])
        ->name('listings.create');

    Route::post('/listings', [ListingController::class, 'store'])
        ->name('listings.store');

    Route::get('/listings/{listing:slug}/edit', [ListingController::class, 'edit'])
        ->name('listings.edit');

    Route::put('/listings/{listing:slug}', [ListingController::class, 'update'])
        ->name('listings.update');

    Route::delete('/listings/{listing:slug}', [ListingController::class, 'destroy'])
        ->name('listings.destroy');

    // Mark as gifted
    Route::post('/listings/{listing:slug}/gifted', [ListingController::class, 'markAsGifted'])
        ->name('listings.mark-as-gifted');
});

// Breeze auth routes
require __DIR__.'/auth.php';

// Fallback route
Route::fallback(function () {
    return redirect()->route('listings.index');
});
