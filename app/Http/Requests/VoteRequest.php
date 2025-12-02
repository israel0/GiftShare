<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'listing_id' => ['required', 'exists:listings,id'],
            'type' => ['required', 'in:upvote,downvote'],
        ];
    }
}
