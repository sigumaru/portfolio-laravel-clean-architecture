<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ管理</title>
</head>
<body style="font-family: sans-serif; max-width: 1200px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => 'お問い合わせ管理'])

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

    <div style="margin-bottom: 1.5rem; padding: 1rem; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 0.25rem;">
        <p style="margin: 0; color: #92400e;">
            <strong>未読メッセージ: {{ $unreadCount }}</strong>
        </p>
    </div>

    @if (empty($contacts) || count($contacts) === 0)
        <p style="color: #6b7280;">お問い合わせがまだありません。</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f9fafb;">
                <tr>
                    <th style="text-align: left; width: 80px;">状態</th>
                    <th style="text-align: left;">名前</th>
                    <th style="text-align: left;">メールアドレス</th>
                    <th style="text-align: left;">件名</th>
                    <th style="text-align: center; width: 150px;">受信日時</th>
                    <th style="text-align: center; width: 150px;">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr style="background: {{ $contact->isRead() ? '#fff' : '#fef3c7' }};">
                        <td style="text-align: center;">
                            <span style="padding: 0.25rem 0.5rem; background: {{ $contact->isRead() ? '#e5e7eb' : '#fbbf24' }}; color: {{ $contact->isRead() ? '#374151' : '#fff' }}; border-radius: 0.25rem; font-size: 0.75rem; font-weight: bold;">
                                {{ $contact->isRead() ? '既読' : '未読' }}
                            </span>
                        </td>
                        <td><strong>{{ $contact->getName() }}</strong></td>
                        <td>{{ $contact->getEmail()->getValue() }}</td>
                        <td>{{ $contact->getSubject() }}</td>
                        <td style="text-align: center; color: #6b7280; font-size: 0.875rem;">
                            {{ $contact->getCreatedAt()->format('Y年m月d日 H:i') }}
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('admin.contact.show', $contact->getId()) }}" style="color: #2563eb; text-decoration: underline; margin-right: 0.5rem;">詳細</a>
                            <form action="{{ route('admin.contact.destroy', $contact->getId()) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; background: none; border: none; text-decoration: underline; cursor: pointer;">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($currentPage > 1)
            <div style="margin-top: 1.5rem;">
                <a href="{{ route('admin.contact.index', ['page' => $currentPage - 1]) }}" style="padding: 0.5rem 1rem; background: #e5e7eb; color: #374151; text-decoration: none; border-radius: 0.25rem;">前のページ</a>
                <span style="margin: 0 1rem; color: #6b7280;">ページ {{ $currentPage }}</span>
            </div>
        @endif
    @endif
</body>
</html>
