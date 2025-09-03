<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\PublishedAt;
use App\Domain\ValueObjects\Slug;
use InvalidArgumentException;

final class BlogPost
{
    private string $id;
    private string $title;
    private Slug $slug;
    private string $content;
    private string $excerpt;
    private ?PublishedAt $publishedAt;
    private bool $isPublished;

    public function __construct(
        string $id,
        string $title,
        string $content,
        string $excerpt = '',
        ?PublishedAt $publishedAt = null,
        bool $isPublished = false
    ) {
        if (empty(trim($title))) {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        if (empty(trim($content))) {
            throw new InvalidArgumentException('Content cannot be empty');
        }

        $this->id = $id;
        $this->title = $title;
        $this->slug = Slug::fromTitle($title);
        $this->content = $content;
        $this->excerpt = empty($excerpt) ? $this->generateExcerpt($content) : $excerpt;
        $this->publishedAt = $publishedAt;
        $this->isPublished = $isPublished;
    }

    public static function create(
        string $id,
        string $title,
        string $content,
        string $excerpt = ''
    ): self {
        return new self($id, $title, $content, $excerpt);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): Slug
    {
        return $this->slug;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    public function getPublishedAt(): ?PublishedAt
    {
        return $this->publishedAt;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function publish(): void
    {
        if ($this->isPublished) {
            return;
        }

        $this->isPublished = true;
        $this->publishedAt = PublishedAt::now();
    }

    public function unpublish(): void
    {
        $this->isPublished = false;
        $this->publishedAt = null;
    }

    public function updateContent(string $title, string $content, string $excerpt = ''): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        if (empty(trim($content))) {
            throw new InvalidArgumentException('Content cannot be empty');
        }

        $this->title = $title;
        $this->slug = Slug::fromTitle($title);
        $this->content = $content;
        $this->excerpt = empty($excerpt) ? $this->generateExcerpt($content) : $excerpt;
    }

    private function generateExcerpt(string $content, int $maxLength = 150): string
    {
        $plainText = strip_tags($content);
        
        if (strlen($plainText) <= $maxLength) {
            return $plainText;
        }

        $excerpt = substr($plainText, 0, $maxLength);
        $lastSpace = strrpos($excerpt, ' ');
        
        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }

        return $excerpt . '...';
    }
}