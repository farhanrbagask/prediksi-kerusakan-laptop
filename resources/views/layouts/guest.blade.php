<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.nam', 'Naive Bayes Prediksi Laptop'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Outfit', sans-serif;
        }

        body {
            min-height: 100vh;
            margin: 0;
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

        /* Glass Card Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(102, 126, 234, 0.3);
        }

        /* Logo Animation */
        .logo-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulse 2s infinite;
            box-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.5);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.5);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 20px 40px -5px rgba(102, 126, 234, 0.8);
            }
        }

        /* Form Input Styles */
        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        /* Button Styles */
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -5px #667eea;
        }

        /* Link Styles */
        .auth-link {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-link:hover {
            color: #667eea;
        }

        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .auth-link:hover::after {
            width: 100%;
        }

        /* Fade In Animation */
        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar */
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

        /* Decorative elements */
        .decor-circle {
            position: fixed;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            filter: blur(80px);
            opacity: 0.2;
            z-index: 0;
        }

        .decor-circle-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
        }

        .decor-circle-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -50px;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Decorative Background Elements -->
    <div class="decor-circle decor-circle-1"></div>
    <div class="decor-circle decor-circle-2"></div>

    <!-- Guest Content -->
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="w-full max-w-md">
            <!-- Logo and Brand -->
            <div class="text-center mb-8 fade-in">
                <div class="logo-wrapper">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">{{ config('app.nam3', 'Naive Bayes Prediksi Laptop') }}
                </h2>
                <p class="text-gray-400 text-sm">Sistem Pakar Diagnostik Kerusakan Laptop</p>
            </div>

            <!-- Main Card -->
            <div class="glass-card p-8 fade-in" style="animation-delay: 0.2s">
                <!-- Session Messages -->
                @if (session('status'))
                    <div class="mb-6">
                        <div
                            class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6">
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl">
                            @foreach ($errors->all() as $error)
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6">
                        <div
                            class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="text-center mt-6 text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
