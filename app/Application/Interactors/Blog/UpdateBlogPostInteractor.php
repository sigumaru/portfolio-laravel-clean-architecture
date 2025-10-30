<?php

declare(strict_types=1);

namespace App\Application\Interactors\Blog;

use App\Application\Contracts\Interactors\Blog\UpdateBlogPostInteractorInterface;
use App\Application\DTOs\BlogPostData;
use App\Application\Responses\BlogPostResponse;
use App\Application\Contracts\Presenters\BlogPresenterInterface;
use App\Domain\Repositories\BlogPostRepositoryInterface;
use InvalidArgumentException;

final class UpdateBlogPostInteractor implements UpdateBlogPostInteractorInterface
{
    public function __construct(
        private BlogPostRepositoryInterface $repository,
        private BlogPresenterInterface $presenter
    ) {}

    public function execute(BlogPostData $data): BlogPostResponse
    {
        $blogPost = $this->repository->findById($data->id);
        
        if (!$blogPost) {
            throw new InvalidArgumentException("Blog post with ID {$data->id} not found");
        }

        $blogPost->updateContent($data->title, $data->content, $data->excerpt);

        if ($data->isPublished && !$blogPost->isPublished()) {
            $blogPost->publish();
        } elseif (!$data->isPublished && $blogPost->isPublished()) {
            $blogPost->unpublish();
        }

        $this->repository->save($blogPost);

        return $this->presenter->present($blogPost);
    }
}