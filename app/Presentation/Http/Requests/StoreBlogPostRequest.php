<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'content' => ['required', 'string', 'min:50'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'is_published' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The blog post title is required.',
            'title.min' => 'The title must be at least 5 characters long.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'content.required' => 'The blog post content is required.',
            'content.min' => 'The content must be at least 50 characters long.',
            'excerpt.max' => 'The excerpt cannot exceed 500 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'title',
            'content' => 'content',
            'excerpt' => 'excerpt',
            'is_published' => 'publication status',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}