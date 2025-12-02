<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Services\VoteService;
use App\DTO\VoteDTO;

class VoteController extends Controller
{
    public function __construct(
        protected VoteService $voteService
    ) {}


}
