<?php

namespace App\DTOs;

class VoteDTO
{
    public function __construct(
        public int $userId,
        public int $listingId,
        public string $type
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            userId: auth()->id(),
            listingId: (int) $data['listing_id'],
            type: $data['type']
        );
    }
}
