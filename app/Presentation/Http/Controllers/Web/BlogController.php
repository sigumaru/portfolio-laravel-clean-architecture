<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Web;

use App\Application\Contracts\Interactors\Blog\GetBlogPostsInteractorInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

final class BlogController
{
    public function __construct(
        private GetBlogPostsInteractorInterface $getBlogPostsInteractor
    ) {}

    public function index(Request $request): View
    {
        $page = (int) $request->get('page', 1);
        $perPage = 10;

        $blogPostsResponse = $this->getBlogPostsInteractor->executePublishedWithPagination($page, $perPage);

        return view('web.blog.index', [
            'blogPosts' => $blogPostsResponse,
            'currentPage' => $page
        ]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        // URLエンコードされたスラッグをデコード
        $decodedSlug = rawurldecode($slug);

        $blogPost = $this->getBlogPostsInteractor->executeBySlug($decodedSlug);

        if (!$blogPost) {
            return redirect()->route('blog.index')
                ->with('error', 'Blog post not found');
        }

        return view('web.blog.show', [
            'blogPost' => $blogPost
        ]);
    }
}