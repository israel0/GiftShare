<?php

namespace App\Livewire\Listing;

use Livewire\Component;
use App\Models\Listing;
use App\Models\Comment;
use App\Services\CommentService;
use App\DTO\CommentDTO;

class CommentSection extends Component
{
    public Listing $listing;
    public string $content = '';
    public ?int $parentId = null;

    protected $rules = [
        'content' => 'required|min:3|max:1000',
    ];

    public function mount(Listing $listing)
    {
        $this->listing = $listing;
    }

    public function submit()
    {
        $this->validate();

        $commentService = app(CommentService::class);
        $dto = new CommentDTO(
            userId: auth()->id(),
            listingId: $this->listing->id,
            parentId: $this->parentId,
            content: $this->content
        );

        $commentService->createComment($dto);

        $this->content = '';
        $this->parentId = null;
        $this->listing->refresh();
    }

    public function replyTo(int $commentId)
    {
        $this->parentId = $commentId;
        $this->dispatch('focus-reply-input');
    }

    public function deleteComment(int $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (auth()->id() !== $comment->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        $comment->delete();
        $this->listing->refresh();
    }

    public function render()
    {
        return view('livewire.listing.comment-section', [
            'comments' => $this->listing->comments()->with(['user', 'replies.user'])->get()
        ]);
    }
}
