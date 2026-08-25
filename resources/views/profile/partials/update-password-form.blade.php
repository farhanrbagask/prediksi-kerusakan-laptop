<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-white mb-2">Password Saat Ini</label>
            <input id="current_password" name="current_password" type="password"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('current_password') border-red-500 @enderror"
                required autocomplete="current-password" placeholder="Masukkan password saat ini" />
            @error('current_password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-white mb-2">Password Baru</label>
            <input id="password" name="password" type="password"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">Konfirmasi Password
                Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                required autocomplete="new-password" placeholder="Ketik ulang password baru" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white text-sm font-medium rounded-xl transition-all duration-200 border border-white/20 shadow-lg">
                Ubah Password
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-400 animate-pulse">
                    ✓ Password berhasil diubah.
                </p>
            @endif
        </div>
    </form>
</section>
