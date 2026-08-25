<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - {{ config('app.nam', 'Naive Bayes System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        * {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Layout Utama */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0f0c29 0%, #302b63 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 50;
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Topbar Styles */
        .topbar {
            height: 70px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Content Wrapper */
        .content-wrapper {
            flex: 1;
            padding: 30px;
        }

        /* Navigation Items */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            cursor: pointer;
            margin: 4px 12px;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            color: #667eea;
            border-left: 3px solid #667eea;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2);
        }

        /* Glass Card Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(102, 126, 234, 0.3);
        }

        /* Stat Value */
        .stat-value {
            font-weight: 700;
        }

        /* Button Icon */
        .btn-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #667eea;
            border-color: #667eea;
            transform: rotate(5deg);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Menu Toggle for Mobile */
        .menu-toggle {
            display: none;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .menu-toggle {
                display: flex;
            }
        }

        /* Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 45;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(102, 126, 234, 0.3);
        }

        /* Grid System */
        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Spacing */
        .gap-4 {
            gap: 1rem;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mt-6 {
            margin-top: 1.5rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .p-8 {
            padding: 2rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* Flexbox */
        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-center {
            justify-content: center;
        }

        .flex-col {
            flex-direction: column;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        /* Text Styles */
        .text-white {
            color: white;
        }

        .text-gray-400 {
            color: #9ca3af;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .text-gray-600 {
            color: #4b5563;
        }

        .text-blue-400 {
            color: #60a5fa;
        }

        .text-green-400 {
            color: #4ade80;
        }

        .text-purple-400 {
            color: #c084fc;
        }

        .text-yellow-400 {
            color: #fbbf24;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .text-4xl {
            font-size: 2.25rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        /* Backgrounds */
        .bg-blue-500\/20 {
            background-color: rgba(59, 130, 246, 0.2);
        }

        .bg-green-500\/20 {
            background-color: rgba(34, 197, 94, 0.2);
        }

        .bg-purple-500\/20 {
            background-color: rgba(168, 85, 247, 0.2);
        }

        .bg-yellow-500\/20 {
            background-color: rgba(234, 179, 8, 0.2);
        }

        .bg-blue-400\/10 {
            background-color: rgba(96, 165, 250, 0.1);
        }

        .bg-green-400\/10 {
            background-color: rgba(74, 222, 128, 0.1);
        }

        .bg-purple-400\/10 {
            background-color: rgba(192, 132, 252, 0.1);
        }

        .bg-yellow-400\/10 {
            background-color: rgba(251, 191, 36, 0.1);
        }

        .bg-gray-700\/50 {
            background-color: rgba(55, 65, 81, 0.5);
        }

        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }

        .from-blue-500 {
            --tw-gradient-from: #3b82f6;
        }

        .to-blue-600 {
            --tw-gradient-to: #2563eb;
        }

        .from-green-500 {
            --tw-gradient-from: #22c55e;
        }

        .to-green-600 {
            --tw-gradient-to: #16a34a;
        }

        .from-yellow-500 {
            --tw-gradient-from: #eab308;
        }

        .to-yellow-600 {
            --tw-gradient-to: #ca8a04;
        }

        .from-purple-500 {
            --tw-gradient-from: #a855f7;
        }

        .to-purple-600 {
            --tw-gradient-to: #9333ea;
        }

        .from-red-500 {
            --tw-gradient-from: #ef4444;
        }

        .to-red-600 {
            --tw-gradient-to: #dc2626;
        }

        .from-gray-500 {
            --tw-gradient-from: #6b7280;
        }

        .to-gray-600 {
            --tw-gradient-to: #4b5563;
        }

        /* Borders */
        .rounded-full {
            border-radius: 9999px;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .rounded-2xl {
            border-radius: 1rem;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .border {
            border-width: 1px;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-gray-700\/50 {
            border-color: rgba(55, 65, 81, 0.5);
        }

        /* Sizing */
        .w-2 {
            width: 0.5rem;
        }

        .w-4 {
            width: 1rem;
        }

        .w-5 {
            width: 1.25rem;
        }

        .w-6 {
            width: 1.5rem;
        }

        .w-7 {
            width: 1.75rem;
        }

        .w-8 {
            width: 2rem;
        }

        .w-10 {
            width: 2.5rem;
        }

        .w-12 {
            width: 3rem;
        }

        .w-16 {
            width: 4rem;
        }

        .w-20 {
            width: 5rem;
        }

        .w-full {
            width: 100%;
        }

        .h-2 {
            height: 0.5rem;
        }

        .h-2\.5 {
            height: 0.625rem;
        }

        .h-4 {
            height: 1rem;
        }

        .h-5 {
            height: 1.25rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .h-7 {
            height: 1.75rem;
        }

        .h-8 {
            height: 2rem;
        }

        .h-10 {
            height: 2.5rem;
        }

        .h-12 {
            height: 3rem;
        }

        .h-16 {
            height: 4rem;
        }

        .h-20 {
            height: 5rem;
        }

        /* Positioning */
        .absolute {
            position: absolute;
        }

        .relative {
            position: relative;
        }

        .bottom-0 {
            bottom: 0;
        }

        .left-0 {
            left: 0;
        }

        .right-0 {
            right: 0;
        }

        /* Hide/Show */
        .hidden {
            display: none;
        }

        .block {
            display: block;
        }

        .inline-block {
            display: inline-block;
        }

        @media (min-width: 768px) {
            .md\:block {
                display: block;
            }
        }

        /* Overflow */
        .overflow-hidden {
            overflow: hidden;
        }

        /* Space */
        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .space-y-5>*+* {
            margin-top: 1.25rem;
        }

        /* Transitions */
        .transition-all {
            transition-property: all;
        }

        .transition-colors {
            transition-property: color, background-color, border-color;
        }

        .duration-300 {
            transition-duration: 300ms;
        }

        .duration-500 {
            transition-duration: 500ms;
        }

        /* Transform */
        .origin-left {
            transform-origin: left;
        }

        .group-hover\:scale-x-105:hover {
            transform: scaleX(1.05);
        }

        /* Text alignment */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* List styles */
        .list-none {
            list-style-type: none;
        }

        /* Cursor */
        .cursor-pointer {
            cursor: pointer;
        }

        /* Z-index */
        .z-10 {
            z-index: 10;
        }
    </style>
</head>

<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">
                            {{ config('app.nam', 'Naive Bayes System') }}
                        </h1>
                        <p class="text-gray-400 text-xs tracking-wider">Pendeteksi Kerusakan Laptop</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 mt-4">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="nav-item active">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4" />
                    </svg>
                    <span>Dashboard</span>
                    <span class="ml-auto w-2 h-2 bg-blue-500 rounded-full"></span>
                </a>

                <!-- Data Latih -->
                <a href="{{ route('data-latih.index') }}" class="nav-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Data Latih</span>
                </a>

                <!-- Data Uji -->
                <a href="{{ route('data-uji.index') }}" class="nav-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Data Uji</span>
                </a>

                <!-- Prediksi -->
                <a href="{{ route('prediksi.index') }}" class="nav-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Prediksi</span>
                </a>

                <!-- Separator -->
                <div class="border-t border-gray-700/50 my-4"></div>

                <!-- Profile -->
                <a href="{{ route('profile.edit') }}" class="nav-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profil Saya</span>
                </a>
            </nav>

            <!-- User Menu at Bottom -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700/50">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="nav-item w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <div id="sidebar-overlay" class="sidebar-overlay"></div>

        <!-- Main Content Area -->
        <div class="main-content" id="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                        <button id="menu-toggle" class="menu-toggle btn-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="page-title">Dashboard</h1>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-wrapper">
                @if (session('success'))
                    <div class="mb-6 fade-in">
                        <div
                            class="bg-green-500/10 border border-green-500/30 text-green-400 px-6 py-4 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 fade-in">
                        <div
                            class="bg-red-500/10 border border-red-500/30 text-red-400 px-6 py-4 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Welcome Section -->
                <div class="mb-8 fade-in">
                    <div class="glass-card rounded-2xl p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-2">
                                    Selamat Datang, {{ Auth::user()->name }}! 👋
                                </h2>
                                <p class="text-gray-400">
                                    Berikut adalah ringkasan sistem diagnostik laptop Anda.
                                </p>
                            </div>
                            <div class="hidden md:block">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Cards - 2 kolom dengan spasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <!-- Total Data Latih -->
                    <div class="glass-card rounded-2xl p-6 fade-in" style="animation-delay: 0.1s">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-blue-400 bg-blue-400/10 px-3 py-1 rounded-full">Dataset</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-1">{{ $totalDataLatih ?? 0 }}</div>
                        <div class="text-sm text-white">Total Data Latih</div>
                        <div class="mt-3 flex items-center gap-2 text-xs text-white">
                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                            <span>Sumber data training</span>
                        </div>
                    </div>

                    <!-- Total Data Uji -->
                    <div class="glass-card rounded-2xl p-6 fade-in" style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-green-400 bg-green-400/10 px-3 py-1 rounded-full">Testing</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-1">{{ $totalDataUji ?? 0 }}</div>
                        <div class="text-sm text-white">Total Data Uji</div>
                        <div class="mt-3 flex items-center gap-2 text-xs text-white">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            <span>Sumber data testing</span>
                        </div>
                    </div>

                    <!-- Total Prediksi -->
                    <div class="glass-card rounded-2xl p-6 fade-in" style="animation-delay: 0.3s">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-purple-400 bg-purple-400/10 px-3 py-1 rounded-full">Hasil</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-1">{{ $totalPrediksi ?? 0 }}</div>
                        <div class="text-sm text-white">Total Prediksi</div>
                        <div class="mt-3 flex items-center gap-2 text-xs text-white">
                            <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                            <span>Total prediksi dilakukan</span>
                        </div>
                    </div>

                    <!-- Akurasi Terakhir -->
                    <div class="glass-card rounded-2xl p-6 fade-in" style="animation-delay: 0.4s">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold text-yellow-400 bg-yellow-400/10 px-3 py-1 rounded-full">Akurasi</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-1">
                            {{ number_format(($metrik['akurasi'] ?? 0) * 100, 2) }}%
                        </div>
                        <div class="text-sm text-white">Akurasi Terakhir</div>
                        <div class="mt-3 flex items-center gap-2 text-xs text-white">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                            <span>Akurasi prediksi terbaru</span>
                        </div>
                    </div>
                </div>

                <!-- Grafik Pembanding -->
                <div class="mb-8 fade-in" style="animation-delay: 0.45s">
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-white">Perbandingan Data Aktual vs Data Prediksi</h3>
                                <p class="text-gray-400 text-xs mt-1">Grafik visual pembanding distribusi kelas pada data uji</p>
                            </div>
                            <span class="text-xs font-semibold text-teal-400 bg-teal-400/10 px-3 py-1 rounded-full">Visualisasi</span>
                        </div>
                        <div class="relative w-full" style="height: 350px;">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Statistik Kelas dan Prediksi Terbaru -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Statistik Kelas -->
                    <div class="glass-card rounded-2xl p-6 fade-in" style="animation-delay: 0.5s">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-white">Distribusi Kelas Data Latih</h3>
                            <span class="text-xs text-gray-400">Total: {{ $totalDataLatih ?? 0 }} data</span>
                        </div>

                        <div class="space-y-5">
                            @php
                                $warna = [
                                    'K1' => 'from-blue-500 to-blue-600',
                                    'K2' => 'from-green-500 to-green-600',
                                    'K3' => 'from-yellow-500 to-yellow-600',
                                    'K4' => 'from-purple-500 to-purple-600',
                                    'K5' => 'from-red-500 to-red-600',
                                ];
                                $icons = [
                                    'K1' =>
                                        'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                                    'K2' =>
                                        'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4',
                                    'K3' =>
                                        'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                                    'K4' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                                    'K5' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                ];
                            @endphp

                            @forelse($statistikKelas ?? [] as $stat)
                                @php
                                    $persentase =
                                        ($totalDataLatih ?? 0) > 0 ? ($stat->total / ($totalDataLatih ?? 1)) * 100 : 0;
                                    $gradientClass = $warna[$stat->kelas] ?? 'from-gray-500 to-gray-600';
                                    $iconPath =
                                        $icons[$stat->kelas] ??
                                        'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';
                                @endphp
                                <div class="group">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $gradientClass }} flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="{{ $iconPath }}" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-white font-medium">{{ $stat->kelas }}</span>
                                                <p class="text-xs text-gray-400">{{ getNamaKelas($stat->kelas) }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-white font-bold">{{ $stat->total }}</span>
                                            <span class="text-gray-400 text-xs ml-1">data</span>
                                            <span
                                                class="block text-xs text-gray-500">{{ number_format($persentase, 1) }}%</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-700/50 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r {{ $gradientClass }} h-2.5 rounded-full transition-all duration-500 group-hover:scale-x-105 origin-left"
                                            style="width: {{ $persentase }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-gray-400">Belum ada data latih</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Prediksi Terbaru -->
                    <div class="glass-card rounded-2xl p-6 fade-in" style="animation-delay: 0.6s">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-white">Hasil Prediksi Terbaru</h3>
                            <a href="{{ route('prediksi.index') }}"
                                class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                Lihat Semua →
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse(($latestPrediksi ?? collect())->take(5) as $prediksi)
                                <div
                                    class="group border-b border-gray-700/50 pb-4 last:border-0 last:pb-0 hover:bg-white/5 p-3 rounded-xl transition-all duration-300">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-300">
                                                Data Uji #{{ $prediksi->dataUji->id_uji ?? $prediksi->id_uji }}
                                            </span>
                                        </div>
                                        <span
                                            class="text-xs text-gray-500">{{ $prediksi->created_at->diffForHumans() }}</span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mt-3">
                                        <div>
                                            <span class="text-xs text-gray-400 block mb-1">Hasil Prediksi</span>
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                                <span
                                                    class="text-white font-medium">{{ $prediksi->hasil_prediksi }}</span>
                                            </div>
                                        </div>

                                        @if (isset($prediksi->kelas_aktual) && $prediksi->kelas_aktual)
                                            <div>
                                                <span class="text-xs text-gray-400 block mb-1">Kelas Aktual</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                                    <span
                                                        class="text-white font-medium">{{ $prediksi->kelas_aktual }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @if (isset($prediksi->kelas_aktual) && $prediksi->kelas_aktual)
                                        <div class="mt-3">
                                            @if ($prediksi->hasil_prediksi == $prediksi->kelas_aktual)
                                                <span
                                                    class="status-badge bg-green-500/20 border-green-500/30 text-green-400">
                                                    ✓ Prediksi Tepat
                                                </span>
                                            @else
                                                <span
                                                    class="status-badge bg-red-500/20 border-red-500/30 text-red-400">
                                                    ✗ Prediksi Tidak Tepat
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-400">Belum ada data prediksi</p>
                                    <a href="{{ route('prediksi.index') }}"
                                        class="text-blue-400 text-sm hover:text-blue-300 mt-2 inline-block">
                                        Mulai Prediksi →
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js Comparison Chart
            const comparisonCanvas = document.getElementById('comparisonChart');
            if (comparisonCanvas) {
                const ctx = comparisonCanvas.getContext('2d');
                const chartData = @json($chartData);
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.nama_labels,
                        datasets: [
                            {
                                label: 'Data Aktual (Label Sebenarnya)',
                                data: chartData.aktual,
                                backgroundColor: 'rgba(59, 130, 246, 0.65)',
                                borderColor: '#3b82f6',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false,
                            },
                            {
                                label: 'Data Prediksi',
                                data: chartData.prediksi,
                                backgroundColor: 'rgba(168, 85, 247, 0.65)',
                                borderColor: '#a855f7',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: '#e2e8f0',
                                    font: {
                                        family: 'Outfit',
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#e2e8f0',
                                titleFont: { family: 'Outfit', weight: 'bold' },
                                bodyFont: { family: 'Outfit' },
                                padding: 12,
                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        family: 'Outfit',
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        family: 'Outfit',
                                        size: 11
                                    },
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const menuToggle = document.getElementById('menu-toggle');
            const mainContent = document.getElementById('main-content');

            if (menuToggle) {
                menuToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    overlay.classList.toggle('show');
                    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' :
                        '';
                });
            }

            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                });
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('mobile-open');
                    if (overlay) overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // Hover effect untuk cards
            const cards = document.querySelectorAll('.glass-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>

</html>

@php
    function getNamaKelas($kelas)
    {
        $nama = [
            'K1' => 'Kerusakan RAM/Memori',
            'K2' => 'Kerusakan Hard Disk/SSD',
            'K3' => 'Kerusakan LCD/Layar',
            'K4' => 'Kerusakan Sistem Operasi',
            'K5' => 'Kerusakan akibat Overheating/Thermal',
        ];
        return $nama[$kelas] ?? $kelas;
    }
@endphp
