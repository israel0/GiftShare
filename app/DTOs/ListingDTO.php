<?php

namespace App\DTOs;

use App\Models\Listing;
use Illuminate\Http\UploadedFile;

class ListingDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public int $categoryId,
        public string $city,
        public ?float $weight = null,
        public ?string $dimensions = null,
        public ?array $photos = null,
        public string $status = 'available'
    ) {}

    public static function fromRequest(array $data, ?array $photos = null): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            categoryId: (int) $data['category_id'],
            city: $data['city'],
            weight: $data['weight'] ?? null,
            dimensions: $data['dimensions'] ?? null,
            photos: $photos,
            status: $data['status'] ?? 'available'
        );
    }

    public static function fromModel(Listing $listing): self
    {
        return new self(
            title: $listing->title,
            description: $listing->description,
            categoryId: $listing->category_id,
            city: $listing->city,
            weight: $listing->weight,
            dimensions: $listing->dimensions,
            status: $listing->status
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'city' => $this->city,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'status' => $this->status,
        ];
    }
}
