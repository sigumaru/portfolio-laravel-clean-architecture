<h1>お問い合わせ</h1>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif
<form method="POST" action="{{ route('contact.store') }}">
    @csrf
    <div>
        <label>お名前: <input type="text" name="name" value="{{ old('name') }}" required></label>
        @error('name')<div style="color:red;">{{ $message }}</div>@enderror
    </div>
    <div>
        <label>メールアドレス: <input type="email" name="email" value="{{ old('email') }}" required></label>
        @error('email')<div style="color:red;">{{ $message }}</div>@enderror
    </div>
    <div>
        <label>件名: <input type="text" name="subject" value="{{ old('subject') }}" required></label>
        @error('subject')<div style="color:red;">{{ $message }}</div>@enderror
    </div>
    <div>
        <label>本文: <textarea name="message" required>{{ old('message') }}</textarea></label>
        @error('message')<div style="color:red;">{{ $message }}</div>@enderror
    </div>
    <button type="submit">送信</button>
</form>
