<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Web;

use App\Application\DTOs\ContactData;
use App\Application\UseCases\Contact\SendContactUseCase;
use App\Presentation\Http\Requests\SendContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

final class ContactController
{
    public function __construct(
        private SendContactUseCase $sendContactUseCase
    ) {}

    public function index(): View
    {
        return view('web.contact');
    }

    public function store(SendContactRequest $request): RedirectResponse
    {
        $contactData = ContactData::create(
            id: Uuid::uuid4()->toString(),
            name: $request->validated('name'),
            email: $request->validated('email'),
            subject: $request->validated('subject'),
            message: $request->validated('message')
        );

        try {
            $this->sendContactUseCase->execute($contactData);

            return redirect()->route('contact.index')
                ->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return redirect()->route('contact.index')
                ->with('error', 'Sorry, there was an error sending your message. Please try again.')
                ->withInput();
        }
    }
}