<!doctype html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>

    <style>
        * {
            font-family: 'Outfit', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(102, 126, 234, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .glow-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .fade-in-delay-1 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .fade-in-delay-2 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .fade-in-delay-3 {
            animation-delay: 0.6s;
            opacity: 0;
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

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .error-message.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-message {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.5);
            color: #86efac;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .success-message.show {
            display: block;
        }

        .show-password-btn {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .show-password-btn:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Checkbox styling */
        .custom-checkbox {
            accent-color: #667eea;
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .custom-checkbox:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .glass-card {
                background: rgba(0, 0, 0, 0.3);
                border-color: rgba(255, 255, 255, 0.05);
            }
        }
    </style>
</head>

<body class="h-full">
    <div class="gradient-bg h-full w-full overflow-auto relative min-h-screen">
        <div class="glow-circle" style="width: 400px; height: 400px; background: #667eea; top: -100px; left: -100px;">
        </div>
        <div class="glow-circle" style="width: 300px; height: 300px; background: #764ba2; bottom: -50px; right: -50px;">
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-full flex items-center justify-center p-6">
            <div class="glass-card rounded-3xl p-8 md:p-12 max-w-sm w-full">

                <!-- Header with Icon -->
                <div class="fade-in text-center mb-8">
                    <div
                        class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30 mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Masuk Akun</h1>
                    <p class="text-gray-300">Selamat kembali di platform kami</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="success-message show mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="fade-in fade-in-delay-1">
                        <label class="block text-sm font-semibold text-gray-200 mb-3">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                            class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-gray-400" required
                            autofocus autocomplete="username" />
                        @error('email')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="fade-in fade-in-delay-1">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-semibold text-gray-200">Password</label>
                            <button type="button" onclick="togglePassword()" class="show-password-btn text-xs"
                                id="show-password-toggle">
                                Tampilkan
                            </button>
                        </div>
                        <div class="relative">
                            <input id="password-input" type="password" name="password" placeholder="••••••••"
                                class="form-input w-full px-4 py-3 rounded-xl text-white placeholder-gray-400" required
                                autocomplete="current-password" />
                        </div>
                        @error('password')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="fade-in fade-in-delay-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember"
                                class="custom-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-300">Ingat saya</span>
                        </label>
                    </div>

                    <!-- Error Display -->
                    @if ($errors->any())
                        <div class="error-message show">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <!-- Login Button -->
                    <button type="submit"
                        class="btn-login w-full py-3 rounded-xl text-white font-semibold text-lg mt-8 transition-all duration-300"
                        id="login-button">
                        Masuk
                    </button>
                </form>

                <!-- Footer Links -->
                <div class="fade-in fade-in-delay-2 mt-6 space-y-4">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="block text-center text-sm text-purple-300 hover:text-purple-200 transition-colors">
                            Lupa Password?
                        </a>
                    @endif

                    <div class="flex items-center gap-3">
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-500 to-transparent"></div>
                        <span class="text-xs text-gray-400">atau</span>
                        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-500 to-transparent"></div>
                    </div>

                    <p class="text-center text-gray-300">
                        Belum punya akun?
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-purple-300 hover:text-purple-200 font-semibold transition-colors">
                                Daftar Sekarang
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password-input');
            const toggleButton = document.getElementById('show-password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = 'Sembunyikan';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = 'Tampilkan';
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            const loginButton = document.getElementById('login-button');
            loginButton.disabled = true;
            loginButton.innerHTML = '⟳ Memproses...';
        });
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</body>

</html>
