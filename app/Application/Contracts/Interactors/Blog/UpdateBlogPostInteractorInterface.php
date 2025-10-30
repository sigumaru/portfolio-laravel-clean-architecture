<?php

declare(strict_types=1);

namespace App\Application\Contracts\Interactors\Blog;

use App\Application\DTOs\BlogPostData;
use App\Application\Responses\BlogPostResponse;
use InvalidArgumentException;

interface UpdateBlogPostInteractorInterface
{
    /**
     * ブログ記事を更新する
     *
     * @param BlogPostData $data 更新するブログ記事データ
     * @return BlogPostResponse 更新されたブログ記事のレスポンス
     * @throws InvalidArgumentException 指定されたIDのブログ記事が存在しない場合
     */
    public function execute(BlogPostData $data): BlogPostResponse;
}