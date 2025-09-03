<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\BlogPost;
use App\Domain\ValueObjects\Slug;

interface BlogPostRepositoryInterface
{
    public function save(BlogPost $blogPost): void;

    public function findById(string $id): ?BlogPost;

    public function findBySlug(Slug $slug): ?BlogPost;

    public function findAll(): array;

    public function findPublished(): array;

    public function findPublishedWithPagination(int $page = 1, int $perPage = 10): array;

    public function findLatest(int $limit = 5): array;

    public function delete(string $id): void;

    public function exists(string $id): bool;

    public function existsBySlug(Slug $slug): bool;

    public function count(): int;

    public function countPublished(): int;
}