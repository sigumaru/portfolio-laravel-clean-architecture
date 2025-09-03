<?php

declare(strict_types=1);

namespace App\Application\Contracts\Services;

use App\Domain\Entities\Contact;

interface MailServiceInterface
{
    public function sendContactNotification(Contact $contact): void;
}