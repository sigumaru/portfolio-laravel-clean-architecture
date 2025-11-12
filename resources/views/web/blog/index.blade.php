@auth
<div style="background:#f0f9ff; border:1px solid #0ea5e9; padding:0.75rem 1rem; margin-bottom:1.5rem;">
    <span style="color:#0369a1; font-weight:bold; margin-right:1rem;">管理者メニュー:</span>
    <a href="{{ route('admin.blog.index') }}" style="color:#0369a1; margin-right:1rem;">ブログ管理</a>
    <a href="{{ route('admin.blog.create') }}" style="color:#0369a1; margin-right:1rem;">新規作成</a>
    <a href="{{ route('admin.dashboard') }}" style="color:#0369a1;">ダッシュボード</a>
</div>
@endauth

<h1>Blog 投稿一覧</h1>
@if (empty($blogPosts->blogPosts))
    <p>公開されているブログ記事がまだありません。</p>
@else
    <ul style="list-style:none; padding:0;">
        @foreach ($blogPosts->blogPosts as $post)
            <li style="margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid #e5e7eb;">
                <div style="margin-bottom:0.5rem;">
                    @if (!empty($post->slug))
                        <a
                            href="{{ url('/blog/' . rawurlencode($post->slug)) }}"
                            style="font-size:1.25rem; font-weight:bold; color:#2563eb; text-decoration:underline;"
                        >
                            {{ $post->title }}
                        </a>
                    @else
                        <span style="font-size:1.25rem; font-weight:bold;">{{ $post->title }}</span>
                        <span style="color:#dc2626; font-size:0.875rem; margin-left:0.5rem;">（スラッグが設定されていません）</span>
                    @endif
                </div>
                @if (!empty($post->excerpt))
                    <p style="color:#6b7280; margin:0.5rem 0;">{{ $post->excerpt }}</p>
                @endif
                <small style="color:#6b7280;">
                    公開日時:
                    @if (!empty($post->publishedAt))
                        {{ \Carbon\Carbon::parse($post->publishedAt)->format('Y年m月d日 H:i') }}
                    @else
                        未公開
                    @endif
                </small>
            </li>
        @endforeach
    </ul>
    @if ($blogPosts->has_more ?? false)
        <p style="margin-top:1.5rem; color:#6b7280;">現在のページ: {{ $blogPosts->page ?? 1 }}</p>
    @endif
@endif
