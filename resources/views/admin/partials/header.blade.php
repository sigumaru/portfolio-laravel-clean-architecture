<header style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h1 style="margin: 0;">{{ $title ?? '管理画面' }}</h1>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <a href="{{ route('home') }}" target="_blank" style="padding: 0.5rem 1rem; background: #10b981; color: #fff; text-decoration: none; border-radius: 0.25rem;">
                公開サイトを見る
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="padding: 0.5rem 1rem; background: #dc2626; color: #fff; border: none; border-radius: 0.25rem; cursor: pointer; font-size: 1rem;">
                    ログアウト
                </button>
            </form>
        </div>
    </div>
    <nav style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('admin.dashboard') }}" style="color: {{ request()->routeIs('admin.dashboard') ? '#2563eb' : '#374151' }}; font-weight: {{ request()->routeIs('admin.dashboard') ? 'bold' : 'normal' }};">ダッシュボード</a>
        <a href="{{ route('admin.blog.index') }}" style="color: {{ request()->routeIs('admin.blog.*') ? '#2563eb' : '#374151' }}; font-weight: {{ request()->routeIs('admin.blog.*') ? 'bold' : 'normal' }};">ブログ管理</a>
        <a href="{{ route('admin.profile.index') }}" style="color: {{ request()->routeIs('admin.profile.*') ? '#2563eb' : '#374151' }}; font-weight: {{ request()->routeIs('admin.profile.*') ? 'bold' : 'normal' }};">プロフィール</a>
    </nav>
</header>
