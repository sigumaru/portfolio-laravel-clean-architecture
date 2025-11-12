<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ管理</title>
</head>
<body style="font-family: sans-serif; max-width: 1200px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => 'ブログ管理'])

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

<div style="margin-bottom:1.5rem;">
    <a
        href="{{ route('admin.blog.create') }}"
        style="display:inline-block; padding:0.5rem 1rem; background:#2563eb; color:#fff; text-decoration:none;"
    >
        新規作成
    </a>
</div>

@if (empty($blogPosts->blogPosts))
    <p>ブログ記事がまだありません。</p>
@else
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f9fafb;">
                <th>タイトル</th>
                <th>概要</th>
                <th>公開状態</th>
                <th>公開日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogPosts->blogPosts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td style="max-width:300px;">
                        @php
                            $excerpt = $post->excerpt ?? '';
                            if (empty($excerpt)) {
                                $displayText = '（概要なし）';
                            } else {
                                $lines = preg_split('/\r\n|\r|\n/', $excerpt);
                                $displayLines = [];
                                foreach ($lines as $line) {
                                    $trimmed = trim($line);
                                    if (!empty($trimmed)) {
                                        $displayLines[] = $trimmed;
                                        if (count($displayLines) >= 2) {
                                            break;
                                        }
                                    }
                                }
                                $displayText = implode(' ', $displayLines);
                                if (strlen($excerpt) > strlen($displayText)) {
                                    $displayText .= '...';
                                }
                            }
                        @endphp
                        <div style="overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; line-height:1.5;">
                            {{ $displayText }}
                        </div>
                    </td>
                    <td>{{ $post->isPublished ? '公開中' : '非公開' }}</td>
                    <td>
                        @if (!empty($post->publishedAt))
                            {{ \Carbon\Carbon::parse($post->publishedAt)->format('Y年m月d日 H:i') }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if (!empty($post->slug))
                            <a href="{{ route('blog.show', ['slug' => rawurlencode($post->slug)]) }}" target="_blank">公開ページ</a> |
                            <a href="{{ route('admin.blog.show', ['slug' => rawurlencode($post->slug)]) }}">詳細</a> |
                            <a href="{{ route('admin.blog.edit', ['slug' => rawurlencode($post->slug)]) }}">編集</a> |
                        @else
                            <span style="color:#6b7280;">公開ページなし</span> |
                            <span style="color:#6b7280;">詳細不可</span> |
                            <span style="color:#6b7280;">編集不可</span> |
                        @endif
                        <form
                            action="{{ route('admin.blog.destroy', ['slug' => rawurlencode($post->slug ?? '')]) }}"
                            method="POST"
                            style="display:inline-block; margin-left:0.5rem;"
                            onsubmit="return confirm('本当に削除しますか？');"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#dc2626; color:#fff; border:none; padding:0.25rem 0.75rem;" {{ empty($post->slug) ? 'disabled' : '' }}>
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</body>
</html>
