<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Admin;

use App\Application\UseCases\Blog\GetBlogPostsUseCase;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Repositories\ProfileRepositoryInterface;
use Illuminate\View\View;

final class DashboardController
{
    public function __construct(
        private GetBlogPostsUseCase $getBlogPostsUseCase,
        private ContactRepositoryInterface $contactRepository,
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function index(): View
    {
        $totalPosts = $this->getBlogPostsUseCase->executeAll()->count();
        $publishedPosts = $this->getBlogPostsUseCase->executePublished()->count();
        $unreadContacts = $this->contactRepository->countUnread();
        $totalContacts = $this->contactRepository->count();
        $profile = $this->profileRepository->find();

        $recentPosts = $this->getBlogPostsUseCase->executeLatest(5);
        $recentContacts = $this->contactRepository->findWithPagination(1, 5);

        return view('admin.dashboard', [
            'stats' => [
                'total_posts' => $totalPosts,
                'published_posts' => $publishedPosts,
                'unread_contacts' => $unreadContacts,
                'total_contacts' => $totalContacts,
                'has_profile' => $profile !== null,
            ],
            'recent_posts' => $recentPosts,
            'recent_contacts' => $recentContacts,
        ]);
    }
}