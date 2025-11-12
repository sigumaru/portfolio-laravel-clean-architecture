<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール管理</title>
</head>
    @include('admin.partials.header', ['title' => 'プロフィール管理'])
        </nav>
    </header>

    @if (session('success'))
        <div style="border:1px solid #86efac; padding:1rem; margin-bottom:1rem; background:#f0fdf4; color:#166534;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="border:1px solid #fca5a5; padding:1rem; margin-bottom:1rem; background:#fef2f2; color:#991b1b;">
            {{ session('error') }}
        </div>
    @endif

    @if ($profile)
        <section style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 2rem; margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem;">
                <div>
                    <h2 style="margin: 0 0 0.5rem 0;">{{ $profile->getName() }}</h2>
                    <p style="margin: 0; color: #6b7280; font-size: 1.125rem;">{{ $profile->getTitle() }}</p>
                </div>
                <a href="{{ route('admin.profile.edit') }}" style="padding: 0.5rem 1rem; background: #2563eb; color: #fff; text-decoration: none; border-radius: 0.25rem;">編集する</a>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="margin: 0 0 0.75rem 0; font-size: 1rem; color: #374151;">自己紹介</h3>
                <p style="margin: 0; line-height: 1.6; white-space: pre-wrap;">{{ $profile->getBio() }}</p>
            </div>

            @if (!empty($profile->getSkills()))
                <div style="margin-bottom: 2rem;">
                    <h3 style="margin: 0 0 0.75rem 0; font-size: 1rem; color: #374151;">スキル</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach ($profile->getSkills() as $skill)
                            <span style="padding: 0.25rem 0.75rem; background: #dbeafe; color: #1e40af; border-radius: 9999px; font-size: 0.875rem;">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (!empty($profile->getExperience()))
                <div style="margin-bottom: 2rem;">
                    <h3 style="margin: 0 0 0.75rem 0; font-size: 1rem; color: #374151;">職務経歴</h3>
                    @foreach ($profile->getExperience() as $exp)
                        <div style="margin-bottom: 1rem; padding-left: 1rem; border-left: 3px solid #2563eb;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 0.9375rem;">{{ $exp['position'] ?? '' }} - {{ $exp['company'] ?? '' }}</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #6b7280;">{{ $exp['duration'] ?? '' }}</p>
                            @if (!empty($exp['description']))
                                <p style="margin: 0; font-size: 0.875rem; line-height: 1.5;">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @if (!empty($profile->getEducation()))
                <div style="margin-bottom: 2rem;">
                    <h3 style="margin: 0 0 0.75rem 0; font-size: 1rem; color: #374151;">学歴</h3>
                    @foreach ($profile->getEducation() as $edu)
                        <div style="margin-bottom: 1rem; padding-left: 1rem; border-left: 3px solid #10b981;">
                            <h4 style="margin: 0 0 0.25rem 0; font-size: 0.9375rem;">{{ $edu['institution'] ?? '' }}</h4>
                            <p style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #6b7280;">{{ $edu['degree'] ?? '' }} - {{ $edu['year'] ?? '' }}</p>
                            @if (!empty($edu['description']))
                                <p style="margin: 0; font-size: 0.875rem; line-height: 1.5;">{{ $edu['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @if (!empty($profile->getSocialLinks()))
                <div>
                    <h3 style="margin: 0 0 0.75rem 0; font-size: 1rem; color: #374151;">ソーシャルリンク</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                        @foreach ($profile->getSocialLinks() as $platform => $url)
                            @if (!empty($url))
                                <a href="{{ $url }}" target="_blank" style="color: #2563eb; text-decoration: underline;">
                                    {{ ucfirst($platform) }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
    @else
        <div style="background: #fef3c7; border: 1px solid #fbbf24; padding: 2rem; text-align: center;">
            <p style="margin: 0 0 1rem 0; font-size: 1.125rem; color: #92400e;">プロフィールが設定されていません。</p>
            <a href="{{ route('admin.profile.edit') }}" style="display: inline-block; padding: 0.75rem 1.5rem; background: #2563eb; color: #fff; text-decoration: none; border-radius: 0.25rem;">
                プロフィールを作成する
            </a>
        </div>
    @endif
</body>
</html>
