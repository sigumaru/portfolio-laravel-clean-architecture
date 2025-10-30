<?php

declare(strict_types=1);

namespace App\Application\Contracts\Interactors\Blog;

use App\Application\DTOs\BlogPostData;
use App\Application\Responses\BlogPostResponse;

interface CreateBlogPostInteractorInterface
{
    /**
     * ブログ記事を作成する
     *
     * @param BlogPostData $data ブログ記事データ
     * @return BlogPostResponse 作成されたブログ記事のレスポンス
     */
    public function execute(BlogPostData $data): BlogPostResponse;
}