<?php

declare(strict_types=1);

namespace App\Presentation\Http\Presenters;

use App\Application\Contracts\Presenters\ContactPresenterInterface;
use App\Application\Responses\ContactResponse;
use App\Domain\Entities\Contact;

final class WebContactPresenter implements ContactPresenterInterface
{
    public function present(Contact $contact): ContactResponse
    {
        return ContactResponse::create(
            id: $contact->getId(),
            name: $contact->getName(),
            email: $contact->getEmail()->getValue(),
            subject: $contact->getSubject(),
            message: $contact->getMessage(),
            createdAt: $contact->getCreatedAt()->format('Y-m-d H:i:s'),
            isRead: $contact->isRead()
        );
    }
}