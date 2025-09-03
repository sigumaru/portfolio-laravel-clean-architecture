<?php

declare(strict_types=1);

namespace App\Application\Contracts\Presenters;

use App\Application\Responses\ProfileResponse;
use App\Domain\Entities\Profile;

interface ProfilePresenterInterface
{
    public function present(Profile $profile): ProfileResponse;
}