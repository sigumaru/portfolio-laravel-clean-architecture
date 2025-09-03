<?php

declare(strict_types=1);

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SendContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255', 'min:5'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your name.',
            'name.min' => 'Your name must be at least 2 characters long.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'subject.required' => 'Please provide a subject for your message.',
            'subject.min' => 'The subject must be at least 5 characters long.',
            'message.required' => 'Please provide your message.',
            'message.min' => 'Your message must be at least 10 characters long.',
            'message.max' => 'Your message cannot exceed 2000 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'subject' => 'subject',
            'message' => 'message',
        ];
    }
}