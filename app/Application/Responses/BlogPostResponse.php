<?php

declare(strict_types=1);

namespace App\Application\Responses;

final class BlogPostResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $slug,
        public readonly string $content,
        public readonly string $excerpt,
        public readonly ?string $publishedAt,
        public readonly bool $isPublished
    ) {}

    public static function create(
        string $id,
        string $title,
        string $slug,
        string $content,
        string $excerpt,
        ?string $publishedAt,
        bool $isPublished
    ): self {
        return new self(
            $id,
            $title,
            $slug,
            $content,
            $excerpt,
            $publishedAt,
            $isPublished
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'published_at' => $this->publishedAt,
            'is_published' => $this->isPublished,
        ];
    }
}