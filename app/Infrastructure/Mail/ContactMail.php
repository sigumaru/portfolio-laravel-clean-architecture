<?php

declare(strict_types=1);

namespace App\Infrastructure\Mail;

use App\Domain\Entities\Contact;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

final class ContactMail extends Mailable
{
    public function __construct(
        private Contact $contact
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form Submission: ' . $this->contact->getSubject(),
            replyTo: $this->contact->getEmail()->getValue()
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'contact' => $this->contact,
            ]
        );
    }
}