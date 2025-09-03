<?php

declare(strict_types=1);

namespace App\Presentation\Http\Presenters;

use App\Application\Contracts\Presenters\BlogPresenterInterface;
use App\Application\Responses\BlogPostResponse;
use App\Application\Responses\BlogPostListResponse;
use App\Domain\Entities\BlogPost;

final class WebBlogPresenter implements BlogPresenterInterface
{
    public function present(BlogPost $blogPost): BlogPostResponse
    {
        return BlogPostResponse::create(
            id: $blogPost->getId(),
            title: $blogPost->getTitle(),
            slug: $blogPost->getSlug()->getValue(),
            content: $blogPost->getContent(),
            excerpt: $blogPost->getExcerpt(),
            publishedAt: $blogPost->getPublishedAt()?->format('Y-m-d H:i:s'),
            isPublished: $blogPost->isPublished()
        );
    }

    public function presentList(array $blogPosts, int $total = 0, int $page = 1, int $perPage = 10): BlogPostListResponse
    {
        $presentedPosts = array_map(
            fn(BlogPost $post) => $this->present($post),
            $blogPosts
        );

        return BlogPostListResponse::create(
            blogPosts: $presentedPosts,
            total: $total ?: count($blogPosts),
            page: $page,
            perPage: $perPage
        );
    }
}