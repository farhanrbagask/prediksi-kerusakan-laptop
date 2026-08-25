@extends('layouts.app')

@section('title', 'Data Latih')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Data Latih</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola data training untuk sistem naive bayes</p>
        </div>
        <div class="flex flex-wrap gap-3 w-full sm:w-auto justify-end">
            <button onclick="confirmDeleteAll()"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-red-500/30 border border-red-400/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span class="text-white">Hapus Semua</span>
            </button>

            <form id="delete-all-form" action="{{ route('data-latih.truncate') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

            <button onclick="openAddModal()"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/30 border border-blue-400/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-white">Tambah Data</span>
            </button>
        </div>
    </div>


    <!-- Tabel Data Latih -->
    <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X1</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X2</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X3</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X4</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X5</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X6</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X7</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X8</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X9</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">X10</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($dataLatih as $index => $data)
                        <tr class="hover:bg-white/10 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                {{ $dataLatih->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->layar_blank }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->layar_bergaris }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->auto_restart }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->boot_loop }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->alarm_bios }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->error_disk }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->keyboard_touchpad_mati }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->baterai_cepat_habis }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->overheat }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">{{ $data->hang }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1.5 text-xs font-bold rounded-full border-2 text-white
                                    @if ($data->kelas == 'K1') bg-blue-500/50 border-blue-300
                                    @elseif($data->kelas == 'K2') bg-green-500/50 border-green-300
                                    @elseif($data->kelas == 'K3') bg-yellow-500/50 border-yellow-300
                                    @elseif($data->kelas == 'K4') bg-purple-500/50 border-purple-300
                                    @elseif($data->kelas == 'K5') bg-red-500/50 border-red-300
                                    @else bg-gray-500/50 border-gray-300 @endif">
                                    {{ $data->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-3">
                                    <button onclick="openEditModal('{{ $data->id_latih }}')"
                                        class="text-white hover:text-white transition-colors p-1.5 hover:bg-white/20 rounded-lg bg-white/10 border border-white/20"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('data-latih.destroy', $data->id_latih) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="text-white hover:text-white transition-colors p-1.5 hover:bg-white/20 rounded-lg bg-white/10 border border-white/20"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="px-6 py-12 text-center">
                                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                                    <svg class="w-20 h-20 text-white/40 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-xl font-bold text-white mb-2">Belum ada data latih</p>
                                    <p class="text-white/60">Klik tombol Tambah Data untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dataLatih->hasPages())
            <div class="px-6 py-4 border-t border-white/20 bg-white/5">
                {{ $dataLatih->links() }}
            </div>
        @endif
    </div>

    <div id="dataModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <div
                class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-2xl border border-gray-200">

                <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3" id="modalTitle">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Data Latih
                        </h3>
                        <button onclick="closeModal()"
                            class="text-gray-500 hover:text-gray-700 transition-colors hover:bg-gray-200 rounded-lg p-1.5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-5 bg-white">
                    <div class="flex border-b border-gray-200 mb-6">
                        <button onclick="switchTab('form')" id="tabFormBtn"
                            class="px-5 py-2.5 text-sm font-semibold text-blue-600 border-b-2 border-blue-600 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Input Form
                        </button>
                        <button onclick="switchTab('excel')" id="tabExcelBtn"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors ml-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload Excel
                        </button>
                    </div>

                    <div id="formTab" class="space-y-4">
                        <form id="dataForm" method="POST" action="{{ route('data-latih.store') }}">
                            @csrf
                            <input type="hidden" id="formMethod" name="_method" value="POST">
                            <input type="hidden" id="dataId" name="id">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-4">
                                    <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2">
                                        Gejala 1-5</h4>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X1 - Layar
                                            Blank</label>
                                        <select name="layar_blank" id="layar_blank" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X2 - Layar
                                            Bergaris</label>
                                        <select name="layar_bergaris" id="layar_bergaris" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X3 - Auto
                                            Restart</label>
                                        <select name="auto_restart" id="auto_restart" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X4 - Boot Loop</label>
                                        <select name="boot_loop" id="boot_loop" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X5 - Alarm BIOS</label>
                                        <select name="alarm_bios" id="alarm_bios" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <h4 class="text-sm font-bold text-gray-700 border-b border-gray-200 pb-2">
                                        Gejala 6-10</h4>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X6 - Error Disk</label>
                                        <select name="error_disk" id="error_disk" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X7 -
                                            Keyboard/Touchpad</label>
                                        <select name="keyboard_touchpad_mati" id="keyboard_touchpad_mati" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X8 - Baterai Cepat
                                            Habis</label>
                                        <select name="baterai_cepat_habis" id="baterai_cepat_habis" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X9 - Overheat</label>
                                        <select name="overheat" id="overheat" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">X10 - Hang</label>
                                        <select name="hang" id="hang" required
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                            <option value="" class="bg-white text-gray-900">Pilih kondisi</option>
                                            <option value="1" class="bg-white text-gray-900">Tidak (1)</option>
                                            <option value="2" class="bg-white text-gray-900">Ya (2)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas Kerusakan</label>
                                <select name="kelas" id="kelas" required
                                    class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all shadow-sm">
                                    <option value="" class="bg-white text-gray-900">Pilih kelas kerusakan</option>
                                    <option value="K1" class="bg-white text-gray-900">K1 - Kerusakan RAM/Memori
                                    </option>
                                    <option value="K2" class="bg-white text-gray-900">K2 - Kerusakan Hard Disk/SSD
                                    </option>
                                    <option value="K3" class="bg-white text-gray-900">K3 - Kerusakan LCD/Layar
                                    </option>
                                    <option value="K4" class="bg-white text-gray-900">K4 - Kerusakan Sistem Operasi
                                    </option>
                                    <option value="K5" class="bg-white text-gray-900">K5 - Kerusakan akibat
                                        Overheating</option>
                                </select>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" onclick="closeModal()"
                                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors border border-gray-300">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors border border-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="excelTab" class="hidden space-y-4">
                        <form id="excelForm" method="POST" action="{{ route('data-latih.import') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div
                                class="border-3 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-colors bg-gray-50">
                                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-700 text-base font-medium mb-2">Upload file Excel (.xlsx, .xls)</p>
                                <p class="text-gray-500 text-sm mb-5">Download template untuk memudahkan pengisian data</p>
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('data-latih.template') }}"
                                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2.5 rounded-xl transition-colors border border-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download Template
                                    </a>
                                    <label
                                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2.5 rounded-xl transition-colors border border-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Pilih File
                                        <input type="file" name="file" class="hidden" accept=".xlsx,.xls"
                                            required>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400 mt-4">Maksimal 1000 baris data</p>
                            </div>

                            <!-- Modal Footer -->
                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" onclick="closeModal()"
                                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors border border-gray-300">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2.5 rounded-xl transition-colors border border-gray-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Upload File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const editData = @json($dataLatih->items());

        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = `
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Data Latih
            `;
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('dataForm').action = "{{ route('data-latih.store') }}";

            document.getElementById('dataForm').reset();
            document.getElementById('dataId').value = '';

            const selects = document.querySelectorAll('#dataForm select');
            selects.forEach(select => {
                select.selectedIndex = 0;
            });

            switchTab('form');

            document.getElementById('dataModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function openEditModal(id) {
            const data = editData.find(d => d.id_latih === id);
            if (!data) return;

            document.getElementById('modalTitle').innerHTML = `
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data Latih
            `;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('dataForm').action = "{{ url('data-latih') }}/" + id;
            document.getElementById('dataId').value = id;

            document.getElementById('layar_blank').value = data.layar_blank;
            document.getElementById('layar_bergaris').value = data.layar_bergaris;
            document.getElementById('auto_restart').value = data.auto_restart;
            document.getElementById('boot_loop').value = data.boot_loop;
            document.getElementById('alarm_bios').value = data.alarm_bios;
            document.getElementById('error_disk').value = data.error_disk;
            document.getElementById('keyboard_touchpad_mati').value = data.keyboard_touchpad_mati;
            document.getElementById('baterai_cepat_habis').value = data.baterai_cepat_habis;
            document.getElementById('overheat').value = data.overheat;
            document.getElementById('hang').value = data.hang;
            document.getElementById('kelas').value = data.kelas;

            switchTab('form');

            document.getElementById('dataModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('dataModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function switchTab(tab) {
            const formTab = document.getElementById('formTab');
            const excelTab = document.getElementById('excelTab');
            const tabFormBtn = document.getElementById('tabFormBtn');
            const tabExcelBtn = document.getElementById('tabExcelBtn');

            if (tab === 'form') {
                formTab.classList.remove('hidden');
                excelTab.classList.add('hidden');

                tabFormBtn.classList.add('text-blue-600', 'border-blue-600');
                tabFormBtn.classList.remove('text-gray-500', 'border-transparent');

                tabExcelBtn.classList.remove('text-blue-600', 'border-blue-600');
                tabExcelBtn.classList.add('text-gray-500', 'border-transparent');

                tabFormBtn.querySelector('svg')?.classList.add('text-blue-600');
                tabFormBtn.querySelector('svg')?.classList.remove('text-gray-500');

                tabExcelBtn.querySelector('svg')?.classList.remove('text-blue-600');
                tabExcelBtn.querySelector('svg')?.classList.add('text-gray-500');
            } else {
                formTab.classList.add('hidden');
                excelTab.classList.remove('hidden');

                tabExcelBtn.classList.add('text-blue-600', 'border-blue-600');
                tabExcelBtn.classList.remove('text-gray-500', 'border-transparent');

                tabFormBtn.classList.remove('text-blue-600', 'border-blue-600');
                tabFormBtn.classList.add('text-gray-500', 'border-transparent');

                tabExcelBtn.querySelector('svg')?.classList.add('text-blue-600');
                tabExcelBtn.querySelector('svg')?.classList.remove('text-gray-500');

                tabFormBtn.querySelector('svg')?.classList.remove('text-blue-600');
                tabFormBtn.querySelector('svg')?.classList.add('text-gray-500');
            }
        }

        function confirmDeleteAll() {
            if (confirm('Yakin ingin menghapus SEMUA data latih? Tindakan ini tidak dapat dibatalkan!')) {
                document.getElementById('delete-all-form').submit();
            }
        }

        document.getElementById('dataModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('dataModal').classList.contains('hidden')) {
                closeModal();
            }
        });

        document.querySelector('#dataModal .relative').addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
@endsection

@push('styles')
    <style>
        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            padding: 0.5rem 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            color: white;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            border-color: transparent;
        }

        .pagination .page-item .page-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #dataModal .relative {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #dataModal .overflow-y-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f1f5f9;
        }

        #dataModal .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        #dataModal .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #dataModal .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        #dataModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .bg-white\/20 {
            font-family: monospace;
            font-weight: 600;
        }

        select option:checked {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
    </style>
@endpush
