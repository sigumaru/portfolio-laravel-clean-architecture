<?php

declare(strict_types=1);

namespace App\Application\UseCases\Blog;

use App\Application\DTOs\BlogPostData;
use App\Application\Responses\BlogPostResponse;
use App\Application\Contracts\Presenters\BlogPresenterInterface;
use App\Domain\Entities\BlogPost;
use App\Domain\Repositories\BlogPostRepositoryInterface;

final class CreateBlogPostUseCase
{
    public function __construct(
        private BlogPostRepositoryInterface $repository,
        private BlogPresenterInterface $presenter
    ) {}

    public function execute(BlogPostData $data): BlogPostResponse
    {
        $blogPost = BlogPost::create(
            $data->id,
            $data->title,
            $data->content,
            $data->excerpt
        );

        if ($data->isPublished) {
            $blogPost->publish();
        }

        $this->repository->save($blogPost);

        return $this->presenter->present($blogPost);
    }
}