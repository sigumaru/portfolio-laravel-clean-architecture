<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Web;

use App\Application\UseCases\Blog\GetBlogPostsUseCase;
use App\Application\UseCases\Profile\UpdateProfileUseCase;
use App\Domain\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class HomeController
{
    public function __construct(
        private GetBlogPostsUseCase $getBlogPostsUseCase,
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function index(): View
    {
        $profile = $this->profileRepository->find();
        $latestPosts = $this->getBlogPostsUseCase->executeLatest(3);

        return view('web.home', [
            'profile' => $profile,
            'latestPosts' => $latestPosts
        ]);
    }
}