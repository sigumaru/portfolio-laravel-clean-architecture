<?php

declare(strict_types=1);

namespace App\Application\UseCases\Blog;

use App\Application\Responses\BlogPostListResponse;
use App\Application\Responses\BlogPostResponse;
use App\Application\Contracts\Presenters\BlogPresenterInterface;
use App\Domain\Repositories\BlogPostRepositoryInterface;
use App\Domain\ValueObjects\Slug;

final class GetBlogPostsUseCase
{
    public function __construct(
        private BlogPostRepositoryInterface $repository,
        private BlogPresenterInterface $presenter
    ) {}

    public function executeAll(): BlogPostListResponse
    {
        $blogPosts = $this->repository->findAll();
        return $this->presenter->presentList($blogPosts);
    }

    public function executePublished(): BlogPostListResponse
    {
        $blogPosts = $this->repository->findPublished();
        return $this->presenter->presentList($blogPosts);
    }

    public function executePublishedWithPagination(int $page = 1, int $perPage = 10): BlogPostListResponse
    {
        $blogPosts = $this->repository->findPublishedWithPagination($page, $perPage);
        return $this->presenter->presentList($blogPosts);
    }

    public function executeLatest(int $limit = 5): BlogPostListResponse
    {
        $blogPosts = $this->repository->findLatest($limit);
        return $this->presenter->presentList($blogPosts);
    }

    public function executeBySlug(string $slug): ?BlogPostResponse
    {
        $blogPost = $this->repository->findBySlug(new Slug($slug));
        
        if (!$blogPost) {
            return null;
        }

        return $this->presenter->present($blogPost);
    }
}