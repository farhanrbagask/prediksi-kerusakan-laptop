<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-white mb-2">Nama</label>
            <input id="name" name="name" type="text"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap" />
            @error('name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-white mb-2">Email</label>
            <input id="email" name="email" type="email"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                value="{{ old('email', $user->email) }}" required autocomplete="username"
                placeholder="Masukkan alamat email" />
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Verification Status -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="p-4 bg-yellow-500/20 border border-yellow-500/30 rounded-xl">
                <p class="text-sm text-yellow-300">
                    Email Anda belum terverifikasi.
                    <button form="send-verification"
                        class="underline text-sm text-yellow-300 hover:text-yellow-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-400">
                        Link verifikasi baru telah dikirim ke email Anda.
                    </p>
                @endif
            </div>
        @endif

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white text-sm font-medium rounded-xl transition-all duration-200 border border-white/20 shadow-lg">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-400 animate-pulse">
                    ✓ Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>

<!-- Hidden form for email verification -->
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
@endif
