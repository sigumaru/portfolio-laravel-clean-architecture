<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Admin;

use App\Application\Contracts\Interactors\Blog\GetBlogPostsInteractorInterface;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\Repositories\ProfileRepositoryInterface;
use Illuminate\View\View;

final class DashboardController
{
    public function __construct(
        private GetBlogPostsInteractorInterface $getBlogPostsInteractor,
        private ContactRepositoryInterface $contactRepository,
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function index(): View
    {
        $allPosts = $this->getBlogPostsInteractor->executeAll();
        $totalPosts = $allPosts->count();
        $publishedPosts = $this->getBlogPostsInteractor->executePublished()->count();
        $unreadContacts = $this->contactRepository->countUnread();
        $totalContacts = $this->contactRepository->count();
        $profile = $this->profileRepository->find();

        // 最新5件の記事（公開・非公開含む）を取得
        $recentPosts = new \App\Application\Responses\BlogPostListResponse(
            blogPosts: array_slice($allPosts->blogPosts, 0, 5),
            total: min(5, $totalPosts),
            page: 1,
            perPage: 5
        );
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