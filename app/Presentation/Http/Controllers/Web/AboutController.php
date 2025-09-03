<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Web;

use App\Domain\Repositories\ProfileRepositoryInterface;
use Illuminate\View\View;

final class AboutController
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function index(): View
    {
        $profile = $this->profileRepository->find();

        return view('web.about', [
            'profile' => $profile
        ]);
    }
}