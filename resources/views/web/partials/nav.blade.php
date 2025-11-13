<nav style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 8px; padding: 1rem; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
            <a href="{{ route('home') }}" style="color: {{ request()->routeIs('home') ? '#2563eb' : '#374151' }}; font-weight: {{ request()->routeIs('home') ? 'bold' : 'normal' }}; text-decoration: none;">ホーム</a>
            <a href="{{ route('about') }}" style="color: {{ request()->routeIs('about') ? '#2563eb' : '#374151' }}; font-weight: {{ request()->routeIs('about') ? 'bold' : 'normal' }}; text-decoration: none;">About</a>
            <a href="{{ route('blog.index') }}" style="color: {{ request()->routeIs('blog.*') ? '#2563eb' : '#374151' }}; font-weight: {{ request()->routeIs('blog.*') ? 'bold' : 'normal' }}; text-decoration: none;">ブログ</a>
        </div>
        @auth
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <a href="{{ route('admin.dashboard') }}" style="padding: 0.5rem 1rem; background: #3b82f6; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">管理画面</a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="padding: 0.5rem 1rem; background: #dc2626; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">ログアウト</button>
            </form>
        </div>
        @else
        <a href="{{ route('login') }}" style="padding: 0.5rem 1rem; background: #f59e0b; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">ログイン</a>
        @endauth
    </div>
</nav>
