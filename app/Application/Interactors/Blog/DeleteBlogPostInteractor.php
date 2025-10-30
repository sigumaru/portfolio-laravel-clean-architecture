<?php

declare(strict_types=1);

namespace App\Application\Interactors\Blog;

use App\Application\Contracts\Interactors\Blog\DeleteBlogPostInteractorInterface;
use App\Domain\Repositories\BlogPostRepositoryInterface;
use InvalidArgumentException;

final class DeleteBlogPostInteractor implements DeleteBlogPostInteractorInterface
{
    public function __construct(
        private BlogPostRepositoryInterface $repository
    ) {}

    public function execute(string $id): void
    {
        if (!$this->repository->exists($id)) {
            throw new InvalidArgumentException("Blog post with ID {$id} not found");
        }

        $this->repository->delete($id);
    }
}