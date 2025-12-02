<?php

namespace App\Livewire\Listing;

use Livewire\Component;
use App\Services\VoteService;
use App\DTO\VoteDTO;
use App\Models\Listing;

class VoteButton extends Component
{
    public Listing $listing;
    public int $upvotes;
    public int $downvotes;
    public ?string $userVote = null;

    public function mount(Listing $listing)
    {
        $this->listing = $listing;
        $this->upvotes = $listing->upvotes_count;
        $this->downvotes = $listing->downvotes_count;
        $this->userVote = auth()->user()?->getVoteFor($listing);
    }

    public function vote(string $type)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $voteService = app(VoteService::class);
        $dto = new VoteDTO(
            userId: auth()->id(),
            listingId: $this->listing->id,
            type: $type
        );

        $voteService->toggleVote($dto);

        // Refresh counts
        $this->listing->refresh();
        $this->upvotes = $this->listing->upvotes_count;
        $this->downvotes = $this->listing->downvotes_count;
        $this->userVote = auth()->user()->getVoteFor($this->listing);
    }

    public function render()
    {
        return view('livewire.listing.vote-button');
    }
}
