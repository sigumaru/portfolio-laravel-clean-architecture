@php($current = $blogPost ?? null)

<div>
    @if ($errors->any())
        <div style="border:1px solid #fca5a5; padding:1rem; margin-bottom:1rem;">
            <h2 style="margin:0 0 0.5rem 0;">エラーが発生しました</h2>
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="margin-bottom:1rem;">
        <label for="title">タイトル</label><br>
        <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title', optional($current)->title ?? '') }}"
            style="width:100%; padding:0.5rem;"
            required
        >
    </div>

    <div style="margin-bottom:1rem;">
        <label for="excerpt">概要</label><br>
        <textarea
            id="excerpt"
            name="excerpt"
            rows="3"
            style="width:100%; padding:0.5rem;"
        >{{ old('excerpt', optional($current)->excerpt ?? '') }}</textarea>
    </div>

    <div style="margin-bottom:1rem;">
        <label for="content">本文</label><br>
        <textarea
            id="content"
            name="content"
            rows="10"
            style="width:100%; padding:0.5rem;"
            required
        >{{ old('content', optional($current)->content ?? '') }}</textarea>
    </div>

    <div style="margin-bottom:1.5rem;">
        <label>
            <input
                type="checkbox"
                name="is_published"
                value="1"
                {{ old('is_published', optional($current)->isPublished ?? false) ? 'checked' : '' }}
            >
            公開する
        </label>
    </div>
</div>

