<h1>About</h1>
@if($profile)
  <h2>{{ $profile->name }}</h2>
  <p>{{ $profile->bio }}</p>
@endif
