<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ記事詳細</title>
</head>
<body style="font-family: sans-serif; max-width: 1000px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => 'ブログ記事詳細'])

@if (session('success'))
    <div style="border:1px solid #86efac; padding:1rem; margin-bottom:1rem; background:#f0fdf4;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="border:1px solid #fca5a5; padding:1rem; margin-bottom:1rem; background:#fef2f2;">
        {{ session('error') }}
    </div>
@endif

<div style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 2rem; background: #ffffff;">
<dl>
    <dt>タイトル</dt>
    <dd>{{ $blogPost->title }}</dd>

    <dt>スラッグ</dt>
    <dd>
        <code style="background:#f3f4f6; padding:0.25rem 0.5rem; font-size:0.85rem; color:#374151;">{{ $blogPost->slug }}</code>
        @if (preg_match('/^[0-9a-f]{12}$/', $blogPost->slug))
            <span style="display:block; color:#6b7280; font-size:0.75rem; margin-top:0.25rem;">※ 自動生成されたスラッグです</span>
        @endif
    </dd>

    <dt>公開状態</dt>
    <dd>{{ $blogPost->isPublished ? '公開中' : '非公開' }}</dd>

    <dt>公開日時</dt>
    <dd>
        @if (!empty($blogPost->publishedAt))
            {{ \Carbon\Carbon::parse($blogPost->publishedAt)->format('Y年m月d日 H:i') }}
        @else
            —
        @endif
    </dd>

    <dt>概要</dt>
    <dd>{!! nl2br(e($blogPost->excerpt)) !!}</dd>

    <dt>本文</dt>
    <dd>{!! nl2br(e($blogPost->content)) !!}</dd>
</dl>

<div style="margin-top:1.5rem;">
    <a href="{{ route('admin.blog.edit', rawurlencode($blogPost->slug)) }}">編集</a> |
    <a href="{{ route('admin.blog.index') }}">一覧に戻る</a>
</div>
</div>
</body>
</html>
