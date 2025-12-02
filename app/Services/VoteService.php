<?php

namespace App\Services;

use App\DTO\VoteDTO;
use App\Models\Vote;
use App\Repositories\Contracts\VoteRepositoryInterface;

class VoteService
{
    public function __construct(
        protected VoteRepositoryInterface $voteRepository
    ) {}

    public function toggleVote(VoteDTO $dto): Vote
    {
        return $this->voteRepository->toggleVote(
            $dto->userId,
            $dto->listingId,
            $dto->type
        );
    }

    public function removeVote(int $userId, int $listingId): bool
    {
        return $this->voteRepository->removeVote($userId, $listingId);
    }

    public function getUserVote(int $userId, int $listingId): ?string
    {
        $vote = $this->voteRepository->getUserVote($userId, $listingId);
        return $vote?->type;
    }
}
