<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Services\VoteService;
use App\DTO\VoteDTO;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    public function __construct(
        protected VoteService $voteService
    ) {}

    public function toggle(VoteRequest $request): JsonResponse
    {
        $dto = VoteDTO::fromRequest($request->validated());
        $vote = $this->voteService->toggleVote($dto);

        return response()->json([
            'success' => true,
            'vote' => $vote,
            'message' => 'Vote updated successfully'
        ]);
    }
}
