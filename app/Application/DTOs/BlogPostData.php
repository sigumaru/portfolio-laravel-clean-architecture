<?php

declare(strict_types=1);

namespace App\Application\DTOs;

final class BlogPostData
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $excerpt = '',
        public readonly bool $isPublished = false
    ) {}

    public static function create(
        string $id,
        string $title,
        string $content,
        string $excerpt = '',
        bool $isPublished = false
    ): self {
        return new self($id, $title, $content, $excerpt, $isPublished);
    }
}