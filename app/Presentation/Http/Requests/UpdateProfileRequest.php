<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'profile_image' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:100'],
            'experience' => ['nullable', 'array'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.position' => ['nullable', 'string', 'max:255'],
            'experience.*.duration' => ['nullable', 'string', 'max:100'],
            'experience.*.description' => ['nullable', 'string', 'max:1000'],
            'education' => ['nullable', 'array'],
            'education.*.institution' => ['nullable', 'string', 'max:255'],
            'education.*.degree' => ['nullable', 'string', 'max:255'],
            'education.*.year' => ['nullable', 'string', 'max:50'],
            'education.*.description' => ['nullable', 'string', 'max:500'],
            'social_links' => ['nullable', 'array'],
            'social_links.github' => ['nullable', 'url', 'max:255'],
            'social_links.linkedin' => ['nullable', 'url', 'max:255'],
            'social_links.twitter' => ['nullable', 'url', 'max:255'],
            'social_links.website' => ['nullable', 'url', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // 空の文字列やnullをフィルタリング
        if ($this->has('skills')) {
            $this->merge([
                'skills' => array_filter(
                    $this->input('skills', []),
                    fn($skill) => $skill !== null && trim($skill) !== ''
                )
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => '名前は必須です。',
            'title.required' => '肩書きは必須です。',
            'bio.required' => '自己紹介は必須です。',
            'social_links.*.url' => '有効なURLを入力してください。',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
            'title' => 'professional title',
            'bio' => 'bio',
            'profile_image' => 'profile image',
            'skills' => 'skills',
            'experience' => 'experience',
            'education' => 'education',
            'social_links' => 'social links',
        ];
    }
}