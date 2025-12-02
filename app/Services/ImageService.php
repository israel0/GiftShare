<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    protected const LISTING_IMAGE_WIDTH = 800;
    protected const LISTING_THUMBNAIL_WIDTH = 300;

    public function storeListingPhoto(UploadedFile $file): array
    {
        $filename = time() . '_' . str()->random(10) . '.' . $file->getClientOriginalExtension();

        // Store original
        $path = $file->storeAs('listings', $filename, 'public');

        // Create and store thumbnail
        $thumbnail = $this->createThumbnail($file);
        $thumbnailPath = 'listings/thumbnails/' . $filename;
        Storage::disk('public')->put($thumbnailPath, $thumbnail->encode());

        return [
            'path' => $path,
            'thumbnail_path' => $thumbnailPath
        ];
    }

    protected function createThumbnail(UploadedFile $file): \Intervention\Image\Image
    {
        $image = Image::make($file);

        return $image->resize(self::LISTING_THUMBNAIL_WIDTH, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    public function deletePhoto(string $path, string $thumbnailPath): void
    {
        Storage::disk('public')->delete([$path, $thumbnailPath]);
    }
}
