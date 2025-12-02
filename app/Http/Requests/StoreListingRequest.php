<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'category_id' => ['required', 'exists:categories,id'],
            'city' => ['required', 'string', 'max:100'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:50'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'photos.max' => 'You can upload maximum 5 photos.',
            'photos.*.max' => 'Each photo must not exceed 5MB.',
        ];
    }
}
