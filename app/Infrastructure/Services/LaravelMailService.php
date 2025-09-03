<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Application\Contracts\Services\MailServiceInterface;
use App\Domain\Entities\Contact;
use App\Infrastructure\Mail\ContactMail;
use Illuminate\Mail\Mailer;

final class LaravelMailService implements MailServiceInterface
{
    public function __construct(
        private Mailer $mailer
    ) {}

    public function sendContactNotification(Contact $contact): void
    {
        $adminEmail = config('mail.admin_email', 'admin@example.com');
        
        $this->mailer->to($adminEmail)
            ->send(new ContactMail($contact));
    }
}