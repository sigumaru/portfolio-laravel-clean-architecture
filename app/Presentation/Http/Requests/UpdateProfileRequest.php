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
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'bio' => ['required', 'string', 'min:50'],
            'profile_image' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string', 'max:100'],
            'experience' => ['nullable', 'array'],
            'experience.*.company' => ['required_with:experience', 'string', 'max:255'],
            'experience.*.position' => ['required_with:experience', 'string', 'max:255'],
            'experience.*.duration' => ['required_with:experience', 'string', 'max:100'],
            'experience.*.description' => ['nullable', 'string', 'max:1000'],
            'education' => ['nullable', 'array'],
            'education.*.institution' => ['required_with:education', 'string', 'max:255'],
            'education.*.degree' => ['required_with:education', 'string', 'max:255'],
            'education.*.year' => ['required_with:education', 'string', 'max:50'],
            'education.*.description' => ['nullable', 'string', 'max:500'],
            'social_links' => ['nullable', 'array'],
            'social_links.github' => ['nullable', 'url', 'max:255'],
            'social_links.linkedin' => ['nullable', 'url', 'max:255'],
            'social_links.twitter' => ['nullable', 'url', 'max:255'],
            'social_links.website' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Your name is required.',
            'name.min' => 'Your name must be at least 2 characters long.',
            'title.required' => 'Your professional title is required.',
            'title.min' => 'Your title must be at least 5 characters long.',
            'bio.required' => 'Your bio is required.',
            'bio.min' => 'Your bio must be at least 50 characters long.',
            'experience.*.company.required_with' => 'Company name is required for experience entries.',
            'experience.*.position.required_with' => 'Position is required for experience entries.',
            'experience.*.duration.required_with' => 'Duration is required for experience entries.',
            'education.*.institution.required_with' => 'Institution name is required for education entries.',
            'education.*.degree.required_with' => 'Degree is required for education entries.',
            'education.*.year.required_with' => 'Year is required for education entries.',
            'social_links.*.url' => 'Please provide a valid URL for social links.',
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