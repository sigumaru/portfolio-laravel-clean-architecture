<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Web;

use App\Application\UseCases\Blog\GetBlogPostsUseCase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

final class BlogController
{
    public function __construct(
        private GetBlogPostsUseCase $getBlogPostsUseCase
    ) {}

    public function index(Request $request): View
    {
        $page = (int) $request->get('page', 1);
        $perPage = 10;

        $blogPostsResponse = $this->getBlogPostsUseCase->executePublishedWithPagination($page, $perPage);

        return view('web.blog.index', [
            'blogPosts' => $blogPostsResponse,
            'currentPage' => $page
        ]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $blogPost = $this->getBlogPostsUseCase->executeBySlug($slug);

        if (!$blogPost) {
            return redirect()->route('blog.index')
                ->with('error', 'Blog post not found');
        }

        return view('web.blog.show', [
            'blogPost' => $blogPost
        ]);
    }
}