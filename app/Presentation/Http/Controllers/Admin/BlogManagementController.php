<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Admin;

use App\Application\Contracts\Interactors\Blog\CreateBlogPostInteractorInterface;
use App\Application\Contracts\Interactors\Blog\DeleteBlogPostInteractorInterface;
use App\Application\Contracts\Interactors\Blog\GetBlogPostsInteractorInterface;
use App\Application\Contracts\Interactors\Blog\UpdateBlogPostInteractorInterface;
use App\Application\DTOs\BlogPostData;
use App\Presentation\Http\Requests\StoreBlogPostRequest;
use App\Presentation\Http\Requests\UpdateBlogPostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

final class BlogManagementController
{
    public function __construct(
        private CreateBlogPostInteractorInterface $createBlogPostInteractor,
        private UpdateBlogPostInteractorInterface $updateBlogPostInteractor,
        private DeleteBlogPostInteractorInterface $deleteBlogPostInteractor,
        private GetBlogPostsInteractorInterface $getBlogPostsInteractor
    ) {}

    public function index(Request $request): View
    {
        $page = (int) $request->get('page', 1);
        $perPage = 20;

        $blogPosts = $this->getBlogPostsInteractor->executeAll();

        return view('admin.blog.index', [
            'blogPosts' => $blogPosts,
            'currentPage' => $page
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.create');
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $blogPostData = BlogPostData::create(
            id: Uuid::uuid4()->toString(),
            title: $request->validated('title'),
            content: $request->validated('content'),
            excerpt: $request->validated('excerpt', ''),
            isPublished: (bool) $request->validated('is_published', false)
        );

        try {
            $blogPost = $this->createBlogPostInteractor->execute($blogPostData);

            return redirect()->route('admin.blog.index')
                ->with('success', 'ブログ記事を作成しました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'ブログ記事の作成に失敗しました: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $slug): View|RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'スラッグが指定されていません。');
        }

        // URLエンコードされたスラッグをデコード
        $decodedSlug = rawurldecode($slug);

        $blogPost = $this->getBlogPostsInteractor->executeBySlug($decodedSlug);

        if (!$blogPost) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'ブログ記事が見つかりませんでした。');
        }

        return view('admin.blog.show', [
            'blogPost' => $blogPost
        ]);
    }

    public function edit(string $slug): View|RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'スラッグが指定されていません。');
        }

        // URLエンコードされたスラッグをデコード
        $decodedSlug = rawurldecode($slug);

        $blogPost = $this->getBlogPostsInteractor->executeBySlug($decodedSlug);

        if (!$blogPost) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'ブログ記事が見つかりませんでした。');
        }

        return view('admin.blog.edit', [
            'blogPost' => $blogPost
        ]);
    }

    public function update(UpdateBlogPostRequest $request, string $slug): RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'スラッグが指定されていません。');
        }

        // URLエンコードされたスラッグをデコード
        $decodedSlug = rawurldecode($slug);

        $blogPost = $this->getBlogPostsInteractor->executeBySlug($decodedSlug);

        if (!$blogPost) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'ブログ記事が見つかりませんでした。');
        }

        $blogPostData = BlogPostData::create(
            id: $blogPost->id,
            title: $request->validated('title'),
            content: $request->validated('content'),
            excerpt: $request->validated('excerpt', ''),
            isPublished: (bool) $request->validated('is_published', false)
        );

        try {
            $updatedBlogPost = $this->updateBlogPostInteractor->execute($blogPostData);

            return redirect()->route('admin.blog.show', rawurlencode($updatedBlogPost->slug))
                ->with('success', 'ブログ記事を更新しました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'ブログ記事の更新に失敗しました: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $slug): RedirectResponse
    {
        if (empty($slug)) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'スラッグが指定されていません。');
        }

        // URLエンコードされたスラッグをデコード
        $decodedSlug = rawurldecode($slug);

        $blogPost = $this->getBlogPostsInteractor->executeBySlug($decodedSlug);

        if (!$blogPost) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'ブログ記事が見つかりませんでした。');
        }

        try {
            $this->deleteBlogPostInteractor->execute($blogPost->id);

            return redirect()->route('admin.blog.index')
                ->with('success', 'ブログ記事を削除しました。');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'ブログ記事の削除に失敗しました: ' . $e->getMessage());
        }
    }
}