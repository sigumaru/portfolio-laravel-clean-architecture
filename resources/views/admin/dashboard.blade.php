<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面ダッシュボード</title>
</head>
<body style="font-family: sans-serif; max-width: 1200px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => '管理画面ダッシュボード'])

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

    <section style="margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">統計情報</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; background: #f9fafb;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #6b7280;">ブログ記事</h3>
                <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #1f2937;">{{ $stats['total_posts'] ?? 0 }}</p>
                <p style="margin: 0.25rem 0 0 0; font-size: 0.75rem; color: #6b7280;">公開中: {{ $stats['published_posts'] ?? 0 }}</p>
            </div>

            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; background: #f9fafb;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #6b7280;">お問い合わせ</h3>
                <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #1f2937;">{{ $stats['total_contacts'] ?? 0 }}</p>
                <p style="margin: 0.25rem 0 0 0; font-size: 0.75rem; color: #dc2626;">未読: {{ $stats['unread_contacts'] ?? 0 }}</p>
            </div>

            <div style="border: 1px solid #e5e7eb; padding: 1.5rem; background: #f9fafb;">
                <h3 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; color: #6b7280;">プロフィール</h3>
                <p style="margin: 0; font-size: 1.25rem; font-weight: bold; color: {{ $stats['has_profile'] ? '#059669' : '#dc2626' }};">
                    {{ $stats['has_profile'] ? '設定済み' : '未設定' }}
                </p>
                @if(!$stats['has_profile'])
                    <a href="{{ route('admin.profile.index') }}" style="font-size: 0.75rem; color: #2563eb;">設定する</a>
                @endif
            </div>
        </div>
    </section>

    <section style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="margin: 0;">最近のブログ記事</h2>
            <a href="{{ route('admin.blog.create') }}" style="padding: 0.5rem 1rem; background: #2563eb; color: #fff; text-decoration: none; border-radius: 0.25rem;">新規作成</a>
        </div>
        @if(empty($recent_posts->blogPosts) || count($recent_posts->blogPosts) === 0)
            <p style="color: #6b7280;">ブログ記事がまだありません。</p>
        @else
            <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="text-align: left;">タイトル</th>
                        <th style="text-align: center; width: 100px;">公開状態</th>
                        <th style="text-align: center; width: 150px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_posts->blogPosts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td style="text-align: center;">
                                <span style="padding: 0.25rem 0.5rem; background: {{ $post->isPublished ? '#d1fae5' : '#fef3c7' }}; color: {{ $post->isPublished ? '#065f46' : '#92400e' }}; border-radius: 0.25rem; font-size: 0.75rem;">
                                    {{ $post->isPublished ? '公開中' : '非公開' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.blog.edit', rawurlencode($post->slug)) }}" style="color: #2563eb; margin-right: 0.5rem;">編集</a>
                                <a href="{{ route('admin.blog.show', rawurlencode($post->slug)) }}" style="color: #2563eb;">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin-top: 1rem;">
                <a href="{{ route('admin.blog.index') }}" style="color: #2563eb;">すべてのブログ記事を見る →</a>
            </p>
        @endif
    </section>

    <section style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="margin: 0;">最近のお問い合わせ</h2>
        </div>
        @if(empty($recent_contacts) || count($recent_contacts) === 0)
            <p style="color: #6b7280;">お問い合わせがまだありません。</p>
        @else
            <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="text-align: left;">名前</th>
                        <th style="text-align: left;">メッセージ</th>
                        <th style="text-align: center; width: 80px;">状態</th>
                        <th style="text-align: center; width: 100px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_contacts as $contact)
                        <tr style="background: {{ $contact->isRead() ? '#fff' : '#fef3c7' }};">
                            <td>{{ $contact->getName() }}</td>
                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ \Illuminate\Support\Str::limit($contact->getMessage(), 50) }}
                            </td>
                            <td style="text-align: center;">
                                <span style="padding: 0.25rem 0.5rem; background: {{ $contact->isRead() ? '#e5e7eb' : '#fef3c7' }}; color: {{ $contact->isRead() ? '#374151' : '#92400e' }}; border-radius: 0.25rem; font-size: 0.75rem;">
                                    {{ $contact->isRead() ? '既読' : '未読' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.contact.show', $contact->getId()) }}" style="color: #2563eb;">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin-top: 1rem;">
                <a href="{{ route('admin.contact.index') }}" style="color: #2563eb;">すべてのお問い合わせを見る →</a>
            </p>
        @endif
    </section>

    <footer style="margin-top: 3rem; padding-top: 1rem; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280; font-size: 0.875rem;">
        <p>© {{ date('Y') }} Portfolio Site. All rights reserved.</p>
    </footer>
</body>
</html>
