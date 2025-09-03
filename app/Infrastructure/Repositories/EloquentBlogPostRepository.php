<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\BlogPost;
use App\Domain\Repositories\BlogPostRepositoryInterface;
use App\Domain\ValueObjects\PublishedAt;
use App\Domain\ValueObjects\Slug;
use App\Infrastructure\Models\BlogPost as BlogPostModel;

final class EloquentBlogPostRepository implements BlogPostRepositoryInterface
{
    public function save(BlogPost $blogPost): void
    {
        BlogPostModel::updateOrCreate(
            ['id' => $blogPost->getId()],
            [
                'title' => $blogPost->getTitle(),
                'slug' => $blogPost->getSlug()->getValue(),
                'content' => $blogPost->getContent(),
                'excerpt' => $blogPost->getExcerpt(),
                'published_at' => $blogPost->getPublishedAt()?->getValue(),
                'is_published' => $blogPost->isPublished(),
            ]
        );
    }

    public function findById(string $id): ?BlogPost
    {
        $model = BlogPostModel::find($id);
        
        if (!$model) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function findBySlug(Slug $slug): ?BlogPost
    {
        $model = BlogPostModel::where('slug', $slug->getValue())->first();
        
        if (!$model) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function findAll(): array
    {
        $models = BlogPostModel::orderBy('created_at', 'desc')->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function findPublished(): array
    {
        $models = BlogPostModel::published()
            ->latest()
            ->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function findPublishedWithPagination(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        
        $models = BlogPostModel::published()
            ->latest()
            ->offset($offset)
            ->limit($perPage)
            ->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function findLatest(int $limit = 5): array
    {
        $models = BlogPostModel::published()
            ->latest()
            ->limit($limit)
            ->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function delete(string $id): void
    {
        BlogPostModel::destroy($id);
    }

    public function exists(string $id): bool
    {
        return BlogPostModel::where('id', $id)->exists();
    }

    public function existsBySlug(Slug $slug): bool
    {
        return BlogPostModel::where('slug', $slug->getValue())->exists();
    }

    public function count(): int
    {
        return BlogPostModel::count();
    }

    public function countPublished(): int
    {
        return BlogPostModel::published()->count();
    }

    private function toDomainEntity(BlogPostModel $model): BlogPost
    {
        $publishedAt = $model->published_at 
            ? PublishedAt::fromString($model->published_at->format('Y-m-d H:i:s'))
            : null;

        return new BlogPost(
            id: $model->id,
            title: $model->title,
            content: $model->content,
            excerpt: $model->excerpt,
            publishedAt: $publishedAt,
            isPublished: $model->is_published
        );
    }
}