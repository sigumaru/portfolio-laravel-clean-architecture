@auth
<div style="background:#f0f9ff; border:1px solid #0ea5e9; padding:0.75rem 1rem; margin-bottom:1.5rem;">
    <span style="color:#0369a1; font-weight:bold; margin-right:1rem;">管理者メニュー:</span>
    <a href="{{ route('admin.blog.index') }}" style="color:#0369a1; margin-right:1rem;">ブログ管理</a>
    <a href="{{ route('admin.blog.edit', rawurlencode($blogPost->slug)) }}" style="color:#0369a1; margin-right:1rem;">この記事を編集</a>
    <a href="{{ route('admin.dashboard') }}" style="color:#0369a1;">ダッシュボード</a>
</div>
@endauth

<h1>{{ $blogPost->title }}</h1>
@if (!empty($blogPost->excerpt))
    <p style="color:#6b7280; font-style:italic;">{{ $blogPost->excerpt }}</p>
@endif
<div style="margin-top:2rem; margin-bottom:2rem;">
    {!! nl2br(e($blogPost->content)) !!}
</div>
@if (!empty($blogPost->publishedAt))
    <p style="color:#6b7280; font-size:0.9rem;">
        公開日時: {{ \Carbon\Carbon::parse($blogPost->publishedAt)->format('Y年m月d日 H:i') }}
    </p>
@endif
<div style="margin-top:2rem;">
    <a href="{{ route('blog.index') }}">一覧へ戻る</a>
</div>
