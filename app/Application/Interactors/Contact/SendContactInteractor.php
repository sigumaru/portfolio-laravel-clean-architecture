<?php

declare(strict_types=1);

namespace App\Application\Interactors\Contact;

use App\Application\Contracts\Interactors\Contact\SendContactInteractorInterface;
use App\Application\DTOs\ContactData;
use App\Application\Responses\ContactResponse;
use App\Application\Contracts\Presenters\ContactPresenterInterface;
use App\Application\Contracts\Services\MailServiceInterface;
use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;

final class SendContactInteractor implements SendContactInteractorInterface
{
    public function __construct(
        private ContactRepositoryInterface $repository,
        private ContactPresenterInterface $presenter,
        private MailServiceInterface $mailService
    ) {}

    public function execute(ContactData $data): ContactResponse
    {
        $contact = Contact::create(
            $data->id,
            $data->name,
            $data->email,
            $data->subject,
            $data->message
        );

        $this->repository->save($contact);

        // Send notification email to admin
        $this->mailService->sendContactNotification($contact);

        return $this->presenter->present($contact);
    }
}