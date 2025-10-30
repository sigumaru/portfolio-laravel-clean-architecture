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
                ->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating blog post: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(string $id): View|RedirectResponse
    {
        $blogPost = $this->getBlogPostsInteractor->executeBySlug($id);

        if (!$blogPost) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'Blog post not found');
        }

        return view('admin.blog.show', [
            'blogPost' => $blogPost
        ]);
    }

    public function edit(string $id): View|RedirectResponse
    {
        $blogPost = $this->getBlogPostsInteractor->executeBySlug($id);

        if (!$blogPost) {
            return redirect()->route('admin.blog.index')
                ->with('error', 'Blog post not found');
        }

        return view('admin.blog.edit', [
            'blogPost' => $blogPost
        ]);
    }

    public function update(UpdateBlogPostRequest $request, string $id): RedirectResponse
    {
        $blogPostData = BlogPostData::create(
            id: $id,
            title: $request->validated('title'),
            content: $request->validated('content'),
            excerpt: $request->validated('excerpt', ''),
            isPublished: (bool) $request->validated('is_published', false)
        );

        try {
            $this->updateBlogPostInteractor->execute($blogPostData);

            return redirect()->route('admin.blog.index')
                ->with('success', 'Blog post updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating blog post: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->deleteBlogPostInteractor->execute($id);

            return redirect()->route('admin.blog.index')
                ->with('success', 'Blog post deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting blog post: ' . $e->getMessage());
        }
    }
}