<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ記事作成</title>
</head>
<body style="font-family: sans-serif; max-width: 1000px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => 'ブログ記事を作成'])

@if (session('error'))
    <div style="border:1px solid #fca5a5; padding:1rem; margin-bottom:1rem; background:#fef2f2;">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('admin.blog.store') }}" method="POST">
    @csrf
@include('admin.blog._form', ['blogPost' => $blogPost ?? null])

    <button type="submit" style="padding:0.5rem 1rem; background:#2563eb; color:#fff; border:none;">
        作成する
    </button>
    <a href="{{ route('admin.blog.index') }}" style="margin-left:1rem;">一覧に戻る</a>
</form>
</body>
</html>
