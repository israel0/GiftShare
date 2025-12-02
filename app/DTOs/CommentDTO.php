<?php

namespace App\DTOs;

class CommentDTO
{
    public function __construct(
        public int $userId,
        public int $listingId,
        public ?int $parentId,
        public string $content
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            userId: auth()->id(),
            listingId: (int) $data['listing_id'],
            parentId: isset($data['parent_id']) ? (int) $data['parent_id'] : null,
            content: $data['content']
        );
    }
}
