<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集</title>
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        .form-input, .form-textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            font-family: inherit;
            font-size: 1rem;
        }
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-hint {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .array-input-group {
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
        }
        .array-input-row {
            margin-bottom: 0.75rem;
        }
        .btn-remove {
            padding: 0.25rem 0.75rem;
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .btn-add {
            padding: 0.5rem 1rem;
            background: #10b981;
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
        }
    </style>
</head>
<body style="font-family: sans-serif; max-width: 1000px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => 'プロフィール編集'])

    @if (session('error'))
        <div style="border:1px solid #fca5a5; padding:1rem; margin-bottom:1rem; background:#fef2f2; color:#991b1b;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="border:1px solid #fca5a5; padding:1rem; margin-bottom:1rem; background:#fef2f2; color:#991b1b;">
            <p style="margin: 0 0 0.5rem 0; font-weight: bold;">入力エラーがあります：</p>
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <section style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 2rem; margin-bottom: 2rem;">
            <h2 style="margin: 0 0 1.5rem 0; font-size: 1.25rem;">基本情報</h2>

            <div class="form-group">
                <label for="name" class="form-label">名前 <span style="color: #dc2626;">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $profile?->getName() ?? '') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="title" class="form-label">肩書き <span style="color: #dc2626;">*</span></label>
                <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $profile?->getTitle() ?? '') }}" required placeholder="例: フルスタックエンジニア">
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio" class="form-label">自己紹介 <span style="color: #dc2626;">*</span></label>
                <textarea id="bio" name="bio" class="form-textarea" required>{{ old('bio', $profile?->getBio() ?? '') }}</textarea>
                <span class="form-hint">あなたの経歴やスキル、興味について詳しく書いてください。</span>
                @error('bio')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_image" class="form-label">プロフィール画像URL</label>
                <input type="text" id="profile_image" name="profile_image" class="form-input" value="{{ old('profile_image', $profile?->getProfileImage() ?? '') }}" placeholder="https://example.com/image.jpg">
                <span class="form-hint">画像のURLを入力してください（オプション）</span>
                @error('profile_image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </section>

        <section style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 2rem; margin-bottom: 2rem;">
            <h2 style="margin: 0 0 1.5rem 0; font-size: 1.25rem;">スキル</h2>

            <div id="skills-container">
                @php
                    $skills = old('skills', $profile?->getSkills() ?? []);
                @endphp
                @forelse ($skills as $index => $skill)
                    <div class="array-input-row" style="display: flex; gap: 0.5rem;">
                        <input type="text" name="skills[]" class="form-input" value="{{ $skill }}" placeholder="例: PHP, Laravel, React">
                        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">削除</button>
                    </div>
                @empty
                    <div class="array-input-row" style="display: flex; gap: 0.5rem;">
                        <input type="text" name="skills[]" class="form-input" placeholder="例: PHP, Laravel, React">
                        <button type="button" class="btn-remove" onclick="this.parentElement.remove()">削除</button>
                    </div>
                @endforelse
            </div>
            <button type="button" class="btn-add" onclick="addSkill()">スキルを追加</button>
        </section>

        <section style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 2rem; margin-bottom: 2rem;">
            <h2 style="margin: 0 0 1.5rem 0; font-size: 1.25rem;">ソーシャルリンク</h2>

            <div class="form-group">
                <label for="github" class="form-label">GitHub</label>
                <input type="url" id="github" name="social_links[github]" class="form-input" value="{{ old('social_links.github', $profile?->getSocialLinks()['github'] ?? '') }}" placeholder="https://github.com/username">
            </div>

            <div class="form-group">
                <label for="linkedin" class="form-label">LinkedIn</label>
                <input type="url" id="linkedin" name="social_links[linkedin]" class="form-input" value="{{ old('social_links.linkedin', $profile?->getSocialLinks()['linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/username">
            </div>

            <div class="form-group">
                <label for="twitter" class="form-label">Twitter</label>
                <input type="url" id="twitter" name="social_links[twitter]" class="form-input" value="{{ old('social_links.twitter', $profile?->getSocialLinks()['twitter'] ?? '') }}" placeholder="https://twitter.com/username">
            </div>

            <div class="form-group">
                <label for="website" class="form-label">ウェブサイト</label>
                <input type="url" id="website" name="social_links[website]" class="form-input" value="{{ old('social_links.website', $profile?->getSocialLinks()['website'] ?? '') }}" placeholder="https://example.com">
            </div>
        </section>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="padding: 0.75rem 2rem; background: #2563eb; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer; font-size: 1rem;">
                保存する
            </button>
            <a href="{{ route('admin.profile.index') }}" style="padding: 0.75rem 2rem; background: #e5e7eb; color: #374151; border: none; border-radius: 0.25rem; text-decoration: none; display: inline-block;">
                キャンセル
            </a>
        </div>
    </form>

    <script>
        function addSkill() {
            const container = document.getElementById('skills-container');
            const div = document.createElement('div');
            div.className = 'array-input-row';
            div.style.display = 'flex';
            div.style.gap = '0.5rem';
            div.innerHTML = `
                <input type="text" name="skills[]" class="form-input" placeholder="例: PHP, Laravel, React">
                <button type="button" class="btn-remove" onclick="this.parentElement.remove()">削除</button>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>
