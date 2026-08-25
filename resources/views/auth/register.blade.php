<!doctype html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>

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

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-register:disabled {
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

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: linear-gradient(90deg, #ef4444 0%, #ef4444 100%);
        }

        .strength-fair {
            background: linear-gradient(90deg, #f59e0b 0%, #f59e0b 50%, rgba(255, 255, 255, 0.1) 50%);
        }

        .strength-good {
            background: linear-gradient(90deg, #3b82f6 0%, #3b82f6 75%, rgba(255, 255, 255, 0.1) 75%);
        }

        .strength-strong {
            background: linear-gradient(90deg, #10b981 0%, #10b981 100%);
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
        <div class="glow-circle"
            style="width: 200px; height: 200px; background: #f093fb; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        </div>

        <!-- Main Content -->
        <div class="relative z-10 min-h-full flex items-center justify-center p-4 md:p-6">
            <div class="glass-card rounded-3xl p-6 md:p-8 max-w-md w-full">

                <!-- Header with Icon -->
                <div class="fade-in text-center mb-6">
                    <div
                        class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30 mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Buat Akun Baru</h1>
                    <p class="text-gray-300 text-sm">Daftar untuk bergabung dengan platform kami</p>
                </div>

                <!-- Error Display -->
                @if ($errors->any())
                    <div class="error-message show mb-4">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4" id="register-form">
                    @csrf

                    <!-- Username -->
                    <div class="fade-in fade-in-delay-1">
                        <label class="block text-sm font-semibold text-gray-200 mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="johndoe123"
                            class="form-input w-full px-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm"
                            required autofocus autocomplete="username" />
                        @error('username')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="fade-in fade-in-delay-1">
                        <label class="block text-sm font-semibold text-gray-200 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="John Doe"
                            class="form-input w-full px-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm"
                            required autocomplete="name" />
                        @error('nama')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="fade-in fade-in-delay-2">
                        <label class="block text-sm font-semibold text-gray-200 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                            class="form-input w-full px-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm"
                            required autocomplete="username" />
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="fade-in fade-in-delay-2">
                        <label class="block text-sm font-semibold text-gray-200 mb-2">Nomor Telepon</label>
                        <input type="text" name="no_telpon" value="{{ old('no_telpon') }}" placeholder="081234567890"
                            class="form-input w-full px-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm"
                            required autocomplete="tel" />
                        @error('no_telpon')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="fade-in fade-in-delay-3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-semibold text-gray-200">Password</label>
                            <button type="button" onclick="togglePassword('password')"
                                class="show-password-btn text-xs" id="show-password-toggle">
                                Tampilkan
                            </button>
                        </div>
                        <div class="relative">
                            <input id="password-input" type="password" name="password" placeholder="Minimal 6 karakter"
                                class="form-input w-full px-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm"
                                required autocomplete="new-password" onkeyup="checkPasswordStrength(this.value)" />
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="password-strength mt-2" id="password-strength"></div>
                        <div class="text-xs text-gray-400 mt-1" id="password-hint">
                            Gunakan minimal 6 karakter dengan kombinasi huruf dan angka
                        </div>
                        @error('password')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="fade-in fade-in-delay-3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-semibold text-gray-200">Konfirmasi Password</label>
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                class="show-password-btn text-xs" id="show-confirm-password-toggle">
                                Tampilkan
                            </button>
                        </div>
                        <div class="relative">
                            <input id="password-confirmation-input" type="password" name="password_confirmation"
                                placeholder="Ketik ulang password"
                                class="form-input w-full px-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm"
                                required autocomplete="new-password" onkeyup="checkPasswordMatch(this.value)" />
                        </div>
                        <div class="text-xs mt-1" id="password-match-hint"></div>
                        @error('password_confirmation')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Register Button -->
                    <div class="fade-in fade-in-delay-3 mt-6">
                        <button type="submit"
                            class="btn-register w-full py-3 rounded-xl text-white font-semibold text-base transition-all duration-300"
                            id="register-button">
                            Daftar
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="fade-in fade-in-delay-3 text-center pt-4">
                        <p class="text-gray-300 text-sm">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="text-purple-300 hover:text-purple-200 font-semibold transition-colors">
                                Masuk
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password Toggle Function
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId === 'password' ? 'password-input' :
                'password-confirmation-input');
            const toggleButton = document.getElementById(fieldId === 'password' ? 'show-password-toggle' :
                'show-confirm-password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = 'Sembunyikan';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = 'Tampilkan';
            }
        }

        // Password Strength Checker
        function checkPasswordStrength(password) {
            const strengthIndicator = document.getElementById('password-strength');
            const hint = document.getElementById('password-hint');

            if (!password) {
                strengthIndicator.className = 'password-strength';
                hint.textContent = 'Gunakan minimal 6 karakter dengan kombinasi huruf dan angka';
                return;
            }

            let strength = 0;

            // Length check
            if (password.length >= 6) strength += 1;
            if (password.length >= 8) strength += 1;

            // Character variety checks
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;

            strengthIndicator.className = 'password-strength';

            if (strength <= 2) {
                strengthIndicator.classList.add('strength-weak');
                hint.textContent = 'Password lemah, gunakan kombinasi yang lebih kuat';
            } else if (strength <= 4) {
                strengthIndicator.classList.add('strength-fair');
                hint.textContent = 'Password cukup baik, bisa ditingkatkan lagi';
            } else if (strength <= 5) {
                strengthIndicator.classList.add('strength-good');
                hint.textContent = 'Password bagus';
            } else {
                strengthIndicator.classList.add('strength-strong');
                hint.textContent = 'Password sangat kuat';
            }
        }

        function checkPasswordMatch(confirmPassword) {
            const password = document.getElementById('password-input').value;
            const matchHint = document.getElementById('password-match-hint');

            if (!confirmPassword) {
                matchHint.textContent = '';
                matchHint.className = 'text-xs mt-1';
                return;
            }

            if (password === confirmPassword) {
                matchHint.textContent = '✓ Password cocok';
                matchHint.className = 'text-xs mt-1 text-green-400';
            } else {
                matchHint.textContent = '✗ Password tidak cocok';
                matchHint.className = 'text-xs mt-1 text-red-400';
            }
        }

        document.getElementById('register-form').addEventListener('submit', function(e) {
            const registerButton = document.getElementById('register-button');
            registerButton.disabled = true;
            registerButton.innerHTML = '⟳ Mendaftarkan...';
        });

        document.getElementById('password-input').addEventListener('keyup', function() {
            const confirmPassword = document.getElementById('password-confirmation-input').value;
            if (confirmPassword) {
                checkPasswordMatch(confirmPassword);
            }
        });
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</body>

</html>
