<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'min:10'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'city' => ['sometimes', 'string', 'max:100'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:50'],
            'status' => ['sometimes', 'in:available,gifted'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ];
    }
}
