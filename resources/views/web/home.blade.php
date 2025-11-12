@auth
<div style="background:#f0f9ff; border:1px solid #0ea5e9; padding:0.75rem 1rem; margin-bottom:1.5rem;">
    <span style="color:#0369a1; font-weight:bold; margin-right:1rem;">管理者メニュー:</span>
    <a href="{{ route('admin.dashboard') }}" style="color:#0369a1; margin-right:1rem;">ダッシュボード</a>
    <a href="{{ route('admin.blog.index') }}" style="color:#0369a1; margin-right:1rem;">ブログ管理</a>
    <a href="{{ route('admin.blog.create') }}" style="color:#0369a1;">新規作成</a>
</div>
@endauth

<h1>ホーム</h1>
@if($profile)
  <h2>{{ $profile->name }}</h2>
  <p>{{ $profile->bio }}</p>
@endif

<h2>最新記事</h2>
<ul>
  @foreach($latestPosts->blogPosts as $post)
    <li style="margin-bottom:0.5rem;">
      <div>
        @if (!empty($post->slug))
          <a href="{{ route('blog.show', ['slug' => rawurlencode($post->slug)]) }}">{{ $post->title }}</a>
        @else
          <span>{{ $post->title }}</span>
        @endif
      </div>
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
