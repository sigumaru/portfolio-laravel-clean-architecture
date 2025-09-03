<?php

declare(strict_types=1);

namespace App\Application\Responses;

final class BlogPostListResponse
{
    /**
     * @param BlogPostResponse[] $blogPosts
     */
    public function __construct(
        public readonly array $blogPosts,
        public readonly int $total = 0,
        public readonly int $page = 1,
        public readonly int $perPage = 10
    ) {}

    /**
     * @param BlogPostResponse[] $blogPosts
     */
    public static function create(
        array $blogPosts,
        int $total = 0,
        int $page = 1,
        int $perPage = 10
    ): self {
        return new self($blogPosts, $total, $page, $perPage);
    }

    public function toArray(): array
    {
        return [
            'data' => array_map(fn($post) => $post->toArray(), $this->blogPosts),
            'total' => $this->total,
            'page' => $this->page,
            'per_page' => $this->perPage,
            'has_more' => ($this->page * $this->perPage) < $this->total,
        ];
    }

    public function isEmpty(): bool
    {
        return empty($this->blogPosts);
    }

    public function count(): int
    {
        return count($this->blogPosts);
    }
}