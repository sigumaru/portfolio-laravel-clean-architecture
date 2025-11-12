<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ詳細</title>
</head>
<body style="font-family: sans-serif; max-width: 900px; margin: 0 auto; padding: 2rem;">
    @include('admin.partials.header', ['title' => 'お問い合わせ詳細'])

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

    <section style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 2rem; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem;">
            <div>
                <span style="padding: 0.25rem 0.75rem; background: {{ $contact->isRead() ? '#e5e7eb' : '#fbbf24' }}; color: {{ $contact->isRead() ? '#374151' : '#fff' }}; border-radius: 0.25rem; font-size: 0.875rem; font-weight: bold;">
                    {{ $contact->isRead() ? '既読' : '未読' }}
                </span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                @if (!$contact->isRead())
                    <form action="{{ route('admin.contact.mark-as-read', $contact->getId()) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="padding: 0.5rem 1rem; background: #10b981; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer;">既読にする</button>
                    </form>
                @else
                    <form action="{{ route('admin.contact.mark-as-unread', $contact->getId()) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="padding: 0.5rem 1rem; background: #f59e0b; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer;">未読にする</button>
                    </form>
                @endif
                <form action="{{ route('admin.contact.destroy', $contact->getId()) }}" method="POST" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding: 0.5rem 1rem; background: #dc2626; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer;">削除</button>
                </form>
            </div>
        </div>

        <dl style="margin: 0;">
            <dt style="margin-bottom: 0.5rem; font-weight: 600; color: #374151;">受信日時</dt>
            <dd style="margin: 0 0 1.5rem 0; color: #6b7280;">
                {{ $contact->getCreatedAt()->format('Y年m月d日 H:i:s') }}
            </dd>

            <dt style="margin-bottom: 0.5rem; font-weight: 600; color: #374151;">名前</dt>
            <dd style="margin: 0 0 1.5rem 0; font-size: 1.125rem;">
                {{ $contact->getName() }}
            </dd>

            <dt style="margin-bottom: 0.5rem; font-weight: 600; color: #374151;">メールアドレス</dt>
            <dd style="margin: 0 0 1.5rem 0;">
                <a href="mailto:{{ $contact->getEmail()->getValue() }}" style="color: #2563eb; text-decoration: underline;">
                    {{ $contact->getEmail()->getValue() }}
                </a>
            </dd>

            <dt style="margin-bottom: 0.5rem; font-weight: 600; color: #374151;">件名</dt>
            <dd style="margin: 0 0 1.5rem 0; font-size: 1.125rem; font-weight: 600;">
                {{ $contact->getSubject() }}
            </dd>

            <dt style="margin-bottom: 0.5rem; font-weight: 600; color: #374151;">メッセージ</dt>
            <dd style="margin: 0; padding: 1rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 0.25rem; line-height: 1.6; white-space: pre-wrap;">{{ $contact->getMessage() }}</dd>
        </dl>
    </section>

    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.contact.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; text-decoration: none; border-radius: 0.25rem; display: inline-block;">
            一覧に戻る
        </a>
    </div>
</body>
</html>
