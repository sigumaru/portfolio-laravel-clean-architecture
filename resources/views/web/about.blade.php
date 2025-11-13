@include('web.partials.nav')

<div style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 2rem; background: #ffffff;">
<h1>About</h1>
@if($profile)
  <h2>{{ $profile->getName() }}</h2>
  <p>{{ $profile->getBio() }}</p>
@endif
</div>
