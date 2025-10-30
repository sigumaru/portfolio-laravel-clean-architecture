<?php

declare(strict_types=1);

namespace App\Application\Contracts\Interactors\Blog;

use InvalidArgumentException;

interface DeleteBlogPostInteractorInterface
{
    /**
     * ブログ記事を削除する
     *
     * @param string $id 削除するブログ記事のID
     * @return void
     * @throws InvalidArgumentException 指定されたIDのブログ記事が存在しない場合
     */
    public function execute(string $id): void;
}