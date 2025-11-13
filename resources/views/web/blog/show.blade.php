@include('web.partials.nav')

<div style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 2rem; background: #ffffff;">
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
</div>
