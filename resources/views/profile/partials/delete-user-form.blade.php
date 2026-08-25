<section>
    <div class="mb-6">
        <p class="text-sm text-white">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
            Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan.
        </p>
    </div>

    <!-- Delete Button Trigger Modal -->
    <div>
        <button type="button" onclick="showDeleteModal()"
            class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white text-sm font-medium rounded-xl transition-all duration-200 border border-white/20 shadow-lg">
            Hapus Akun
        </button>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div
            class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-red-600/40 to-pink-600/40 border-b border-white/20">
                <h3 class="text-lg font-bold text-white">Konfirmasi Hapus Akun</h3>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <div class="mb-6">
                    <p class="text-sm text-gray-300 mb-4">
                        Apakah Anda yakin ingin menghapus akun? Semua data akan dihapus secara permanen.
                        Masukkan password Anda untuk konfirmasi.
                    </p>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <input id="password" name="password" type="password"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                            placeholder="Masukkan password" required />
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="hideDeleteModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors border border-gray-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white text-sm font-medium rounded-xl transition-all duration-200 border border-white/20 shadow-lg">
                        Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                hideDeleteModal();
            }
        }
    </script>
</section>
