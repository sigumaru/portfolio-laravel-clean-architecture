<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCases\Blog;

use App\Application\Contracts\Presenters\BlogPresenterInterface;
use App\Application\Responses\BlogPostListResponse;
use App\Application\Responses\BlogPostResponse;
use App\Application\UseCases\Blog\GetBlogPostsUseCase;
use App\Domain\Entities\BlogPost;
use App\Domain\Repositories\BlogPostRepositoryInterface;
use App\Domain\ValueObjects\Slug;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GetBlogPostsUseCaseTest extends TestCase
{
    /** @var BlogPostRepositoryInterface&MockObject */
    private BlogPostRepositoryInterface $repository;

    /** @var BlogPresenterInterface&MockObject */
    private BlogPresenterInterface $presenter;

    private GetBlogPostsUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(BlogPostRepositoryInterface::class);
        $this->presenter = $this->createMock(BlogPresenterInterface::class);
        $this->useCase = new GetBlogPostsUseCase($this->repository, $this->presenter);
    }

    public function testExecuteAllReturnsPresentedList(): void
    {
        $blogPosts = [$this->makeBlogPost('1'), $this->makeBlogPost('2')];
        $response = BlogPostListResponse::create([]);

        $this->repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($blogPosts);

        $this->presenter
            ->expects($this->once())
            ->method('presentList')
            ->with($blogPosts)
            ->willReturn($response);

        $result = $this->useCase->executeAll();

        self::assertSame($response, $result);
    }

    public function testExecutePublishedReturnsPresentedList(): void
    {
        $blogPosts = [$this->makeBlogPost('10')];
        $response = BlogPostListResponse::create([]);

        $this->repository
            ->expects($this->once())
            ->method('findPublished')
            ->willReturn($blogPosts);

        $this->presenter
            ->expects($this->once())
            ->method('presentList')
            ->with($blogPosts)
            ->willReturn($response);

        $result = $this->useCase->executePublished();

        self::assertSame($response, $result);
    }

    public function testExecutePublishedWithPaginationReturnsPresentedList(): void
    {
        $page = 2;
        $perPage = 15;
        $blogPosts = [$this->makeBlogPost('20')];
        $response = BlogPostListResponse::create([]);

        $this->repository
            ->expects($this->once())
            ->method('findPublishedWithPagination')
            ->with($page, $perPage)
            ->willReturn($blogPosts);

        $this->presenter
            ->expects($this->once())
            ->method('presentList')
            ->with($blogPosts)
            ->willReturn($response);

        $result = $this->useCase->executePublishedWithPagination($page, $perPage);

        self::assertSame($response, $result);
    }

    public function testExecuteLatestReturnsPresentedList(): void
    {
        $limit = 3;
        $blogPosts = [$this->makeBlogPost('30')];
        $response = BlogPostListResponse::create([]);

        $this->repository
            ->expects($this->once())
            ->method('findLatest')
            ->with($limit)
            ->willReturn($blogPosts);

        $this->presenter
            ->expects($this->once())
            ->method('presentList')
            ->with($blogPosts)
            ->willReturn($response);

        $result = $this->useCase->executeLatest($limit);

        self::assertSame($response, $result);
    }

    public function testExecuteBySlugReturnsPresentedBlogPostWhenFound(): void
    {
        $slugValue = 'existing-slug';
        $blogPost = $this->makeBlogPost('100');
        $presentedResponse = BlogPostResponse::create(
            $blogPost->getId(),
            $blogPost->getTitle(),
            (string) $blogPost->getSlug(),
            $blogPost->getContent(),
            $blogPost->getExcerpt(),
            null,
            true
        );

        $this->repository
            ->expects($this->once())
            ->method('findBySlug')
            ->with($this->callback(
                fn ($slug) => $slug instanceof Slug && (string) $slug === $slugValue
            ))
            ->willReturn($blogPost);

        $this->presenter
            ->expects($this->once())
            ->method('present')
            ->with($blogPost)
            ->willReturn($presentedResponse);

        $result = $this->useCase->executeBySlug($slugValue);

        self::assertSame($presentedResponse, $result);
    }

    public function testExecuteBySlugReturnsNullWhenBlogPostNotFound(): void
    {
        $slugValue = 'missing-slug';

        $this->repository
            ->expects($this->once())
            ->method('findBySlug')
            ->with($this->callback(
                fn ($slug) => $slug instanceof Slug && (string) $slug === $slugValue
            ))
            ->willReturn(null);

        $this->presenter
            ->expects($this->never())
            ->method('present');

        $result = $this->useCase->executeBySlug($slugValue);

        self::assertNull($result);
    }

    private function makeBlogPost(string $id, string $title = 'Sample Title'): BlogPost
    {
        return BlogPost::create(
            $id,
            $title,
            'Content for ' . $title,
            'Excerpt for ' . $title
        );
    }
}


