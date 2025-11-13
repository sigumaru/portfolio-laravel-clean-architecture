@include('web.partials.nav')

<div style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 2rem; background: #ffffff;">
<h1>ホーム</h1>
@if($profile)
  <h2>{{ $profile->getName() }}</h2>
  <p>{{ $profile->getBio() }}</p>
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
</div>
