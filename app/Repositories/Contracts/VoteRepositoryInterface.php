<?php

namespace App\Repositories\Contracts;

use App\Models\Vote;

interface VoteRepositoryInterface
{
    public function toggleVote(int $userId, int $listingId, string $type): Vote;
    public function getUserVote(int $userId, int $listingId): ?Vote;
    public function removeVote(int $userId, int $listingId): bool;
}
