<h1>Blog 投稿一覧</h1>
<ul>
    @foreach ($blogPosts->blogPosts as $post)
        <li>
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </li>
    @endforeach
</ul>
<p>現在のページ: {{ $currentPage }}</p>
