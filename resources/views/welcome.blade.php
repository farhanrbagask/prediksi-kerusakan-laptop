<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Welcome') }}</title>

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

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .glow-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
        }

        .fade-in {
            animation: fadeIn 1s ease-out forwards;
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

        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(0);
            }

            50% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Dark mode adjustments */
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

        <!-- Background Elements -->
        <div class="glow-circle" style="width: 400px; height: 400px; background: #667eea; top: -100px; left: -100px;">
        </div>
        <div class="glow-circle" style="width: 300px; height: 300px; background: #764ba2; bottom: -50px; right: -50px;">
        </div>
        <div class="glow-circle"
            style="width: 200px; height: 200px; background: #f093fb; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        </div>

        <!-- Sparkles -->
        <div class="sparkle" style="top: 20%; left: 15%; animation-delay: 0s;"></div>
        <div class="sparkle" style="top: 30%; left: 80%; animation-delay: 0.5s;"></div>
        <div class="sparkle" style="top: 70%; left: 25%; animation-delay: 1s;"></div>
        <div class="sparkle" style="top: 60%; left: 75%; animation-delay: 1.5s;"></div>
        <div class="sparkle" style="top: 85%; left: 50%; animation-delay: 0.7s;"></div>



        <!-- Main Content -->
        <div class="relative z-10 min-h-full flex items-center justify-center p-6">
            <div class="glass-card rounded-3xl p-8 md:p-12 max-w-lg w-full text-center">

                <!-- Logo/Icon -->
                <div class="floating mb-8">
                    <div
                        class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 id="main-title" class="fade-in text-4xl md:text-5xl font-bold text-white mb-4">
                    Selamat Datang
                </h1>

                <!-- Subtitle -->
                <p id="subtitle" class="fade-in fade-in-delay-1 text-xl text-purple-200 font-medium mb-3">
                    Di Analisis Prediksi Kerusakan Laptop Menggunakan Metode Naive Bayes
                </p>

                <!-- Buttons -->
                <div class="fade-in fade-in-delay-3 flex flex-col sm:flex-row gap-4 justify-center">
                    <button id="login-btn" class="btn-primary px-8 py-4 rounded-xl text-white font-semibold text-lg">
                        Masuk
                    </button>
                    <button id="register-btn"
                        class="btn-secondary px-8 py-4 rounded-xl text-white font-semibold text-lg">
                        Daftar
                    </button>
                </div>

                <!-- Footer Text -->
                <p class="mt-10 text-gray-400 text-sm">
                    Dengan melanjutkan, Anda menyetujui
                    <a href="#" class="text-purple-300 hover:text-purple-200 underline">Syarat & Ketentuan</a>
                    kami
                </p>
            </div>
        </div>
    </div>

    <script>
        // Default configuration
        const defaultConfig = {
            main_title: 'Selamat Datang',
            subtitle: 'Di Platform Kami',
            description: 'Mulai perjalanan Anda bersama kami. Daftar sekarang untuk mengakses fitur-fitur menarik yang telah kami siapkan untuk Anda.',
            login_text: 'Masuk',
            register_text: 'Daftar',
            primary_color: '#667eea',
            secondary_color: '#764ba2',
            text_color: '#ffffff',
            bg_color: '#0f0c29',
            accent_color: '#f093fb'
        };

        // Button interactions
        document.getElementById('login-btn').addEventListener('click', function() {
            this.innerHTML = '✓ Membuka Login...';
            setTimeout(() => {
                this.textContent = defaultConfig.login_text;
                @if (Route::has('login'))
                    window.location.href = "{{ route('login') }}";
                @endif
            }, 800);
        });

        document.getElementById('register-btn').addEventListener('click', function() {
            this.innerHTML = '✓ Membuka Pendaftaran...';
            setTimeout(() => {
                this.textContent = defaultConfig.register_text;
                @if (Route::has('register'))
                    window.location.href = "{{ route('register') }}";
                @endif
            }, 800);
        });
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</body>

</html>
