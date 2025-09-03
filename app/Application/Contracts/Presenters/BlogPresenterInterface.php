<?php

declare(strict_types=1);

namespace App\Application\Contracts\Presenters;

use App\Application\Responses\BlogPostResponse;
use App\Application\Responses\BlogPostListResponse;
use App\Domain\Entities\BlogPost;

interface BlogPresenterInterface
{
    public function present(BlogPost $blogPost): BlogPostResponse;

    /**
     * @param BlogPost[] $blogPosts
     */
    public function presentList(array $blogPosts, int $total = 0, int $page = 1, int $perPage = 10): BlogPostListResponse;
}