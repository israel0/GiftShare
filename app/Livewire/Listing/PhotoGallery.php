<?php

namespace App\Livewire\Listing;

use Livewire\Component;
use App\Models\Listing;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Services\ImageService;
use App\Models\ListingPhoto;

class PhotoGallery extends Component
{
    use WithFileUploads;

    public Listing $listing;
    public $photos = [];
    public $uploadedPhotos = [];
    public $showUploadModal = false;
    public $activePhotoIndex = 0;
    public $deletingPhotoId = null;

    protected $listeners = ['refreshGallery' => '$refresh'];

    protected $rules = [
        'uploadedPhotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
    ];

    public function mount(Listing $listing)
    {
        $this->listing = $listing;
    }

    public function openUploadModal()
    {
        $this->authorize('update', $this->listing);
        $this->reset(['uploadedPhotos']);
        $this->showUploadModal = true;
    }

    public function uploadPhotos()
    {
        $this->validate();

        $imageService = app(ImageService::class);

        foreach ($this->uploadedPhotos as $photo) {
            $paths = $imageService->storeListingPhoto($photo);

            $this->listing->photos()->create([
                'path' => $paths['path'],
                'thumbnail_path' => $paths['thumbnail_path'],
                'order' => $this->listing->photos()->count()
            ]);
        }

        $this->showUploadModal = false;
        $this->uploadedPhotos = [];
        $this->listing->refresh();

        session()->flash('success', 'Photos uploaded successfully!');
    }

    public function confirmDelete($photoId)
    {
        $this->authorize('update', $this->listing);
        $this->deletingPhotoId = $photoId;
    }

    public function deletePhoto()
    {
        $photo = ListingPhoto::findOrFail($this->deletingPhotoId);

        // Delete from storage
        Storage::disk('public')->delete([$photo->path, $photo->thumbnail_path]);

        // Delete from database
        $photo->delete();

        // Reorder remaining photos
        $this->reorderPhotos();

        $this->deletingPhotoId = null;
        $this->listing->refresh();

        // Reset active photo index if needed
        if ($this->activePhotoIndex >= $this->listing->photos->count()) {
            $this->activePhotoIndex = max(0, $this->listing->photos->count() - 1);
        }

        session()->flash('success', 'Photo deleted successfully!');
    }

    public function setActivePhoto($index)
    {
        $this->activePhotoIndex = $index;
    }

    public function nextPhoto()
    {
        if ($this->listing->photos->count() > 0) {
            $this->activePhotoIndex = ($this->activePhotoIndex + 1) % $this->listing->photos->count();
        }
    }

    public function previousPhoto()
    {
        if ($this->listing->photos->count() > 0) {
            $this->activePhotoIndex = ($this->activePhotoIndex - 1 + $this->listing->photos->count()) % $this->listing->photos->count();
        }
    }

    public function updatePhotoOrder($order)
    {
        $this->authorize('update', $this->listing);

        foreach ($order as $item) {
            ListingPhoto::where('id', $item['value'])
                ->update(['order' => $item['order']]);
        }

        $this->listing->refresh();
    }

    protected function reorderPhotos()
    {
        $photos = $this->listing->photos()->orderBy('order')->get();

        foreach ($photos as $index => $photo) {
            $photo->update(['order' => $index]);
        }
    }

    public function removeUploadedPhoto($index)
    {
        unset($this->uploadedPhotos[$index]);
        $this->uploadedPhotos = array_values($this->uploadedPhotos);
    }

    public function render()
    {
        return view('livewire.listing.photo-gallery', [
            'photos' => $this->listing->photos()->orderBy('order')->get()
        ]);
    }
}
