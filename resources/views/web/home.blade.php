<h1>ホーム</h1>
@if($profile)
  <h2>{{ $profile->name }}</h2>
  <p>{{ $profile->bio }}</p>
@endif

<h2>最新記事</h2>
<ul>
  @foreach($latestPosts->blogPosts as $post)
    <li><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></li>
  @endforeach
</ul>
