<?php

declare(strict_types=1);

namespace App\Application\Contracts\Interactors\Blog;

use App\Application\Responses\BlogPostListResponse;
use App\Application\Responses\BlogPostResponse;

interface GetBlogPostsInteractorInterface
{
    /**
     * 全てのブログ記事を取得する
     *
     * @return BlogPostListResponse
     */
    public function executeAll(): BlogPostListResponse;

    /**
     * 公開済みのブログ記事を取得する
     *
     * @return BlogPostListResponse
     */
    public function executePublished(): BlogPostListResponse;

    /**
     * 公開済みのブログ記事をページネーション付きで取得する
     *
     * @param int $page ページ番号（デフォルト: 1）
     * @param int $perPage 1ページあたりの記事数（デフォルト: 10）
     * @return BlogPostListResponse
     */
    public function executePublishedWithPagination(int $page = 1, int $perPage = 10): BlogPostListResponse;

    /**
     * 最新のブログ記事を取得する
     *
     * @param int $limit 取得する記事数（デフォルト: 5）
     * @return BlogPostListResponse
     */
    public function executeLatest(int $limit = 5): BlogPostListResponse;

    /**
     * スラッグでブログ記事を取得する
     *
     * @param string $slug ブログ記事のスラッグ
     * @return BlogPostResponse|null 記事が見つからない場合はnull
     */
    public function executeBySlug(string $slug): ?BlogPostResponse;
}