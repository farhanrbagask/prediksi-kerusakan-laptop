<nav class="p-4 mt-4">
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4" />
        </svg>
        <span>Dashboard</span>
        @if (request()->routeIs('dashboard'))
            <span class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></span>
        @endif
    </a>

    <!-- Data Latih -->
    <a href="{{ route('data-latih.index') }}" class="nav-item {{ request()->routeIs('data-latih.*') ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span>Data Latih</span>
        @if (request()->routeIs('data-latih.*'))
            <span class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></span>
        @endif
    </a>

    <!-- Data Uji -->
    <a href="{{ route('data-uji.index') }}" class="nav-item {{ request()->routeIs('data-uji.*') ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <span>Data Uji</span>
        @if (request()->routeIs('data-uji.*'))
            <span class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></span>
        @endif
    </a>

    <!-- Prediksi -->
    <a href="{{ route('prediksi.index') }}" class="nav-item {{ request()->routeIs('prediksi.*') ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <span>Prediksi</span>
        @if (request()->routeIs('prediksi.*'))
            <span class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></span>
        @endif
    </a>

    <!-- Separator -->
    <div class="border-t border-gray-700/50 my-4"></div>

    <!-- Profile -->
    <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span>Profil Saya</span>
        @if (request()->routeIs('profile.*'))
            <span class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></span>
        @endif
    </a>

</nav>
