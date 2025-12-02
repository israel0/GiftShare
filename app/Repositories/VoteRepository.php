<?php

namespace App\Repositories;

use App\Models\Vote;
use App\Models\Listing;
use App\Repositories\Contracts\VoteRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VoteRepository extends EloquentRepository implements VoteRepositoryInterface
{
    public function __construct(Vote $model)
    {
        parent::__construct($model);
    }

    public function toggleVote(int $userId, int $listingId, string $type): Vote
    {
        return DB::transaction(function () use ($userId, $listingId, $type) {
            $existingVote = $this->getUserVote($userId, $listingId);
            $listing = Listing::find($listingId);

            if ($existingVote) {
                $this->removeVote($userId, $listingId);

                if ($existingVote->type === $type) {
                    return $existingVote;
                }
            }

            $vote = $this->create([
                'user_id' => $userId,
                'listing_id' => $listingId,
                'type' => $type
            ]);

            $listing->increment($type === 'upvote' ? 'upvotes_count' : 'downvotes_count');

            return $vote;
        });
    }

    public function getUserVote(int $userId, int $listingId): ?Vote
    {
        return $this->model->where('user_id', $userId)
            ->where('listing_id', $listingId)
            ->first();
    }

    public function removeVote(int $userId, int $listingId): bool
    {
        $vote = $this->getUserVote($userId, $listingId);

        if ($vote) {
            $listing = Listing::find($listingId);
            $listing->decrement($vote->type === 'upvote' ? 'upvotes_count' : 'downvotes_count');

            return $vote->delete();
        }

        return false;
    }
}
