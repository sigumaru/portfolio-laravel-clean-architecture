<?php

declare(strict_types=1);

namespace App\Application\Contracts\Presenters;

use App\Application\Responses\ContactResponse;
use App\Domain\Entities\Contact;

interface ContactPresenterInterface
{
    public function present(Contact $contact): ContactResponse;
}