@extends('layouts.app')

@section('title', 'Hasil Prediksi')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Hasil Prediksi</h1>
        <p class="text-gray-400 text-sm mt-1">Evaluasi performa model naive bayes</p>
    </div>

    @if (isset($metrik) && $metrik['total_data'] > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div
                class="bg-gradient-to-br from-blue-500/20 to-blue-600/20 backdrop-blur-md rounded-xl p-5 border border-blue-400/30">
                <p class="text-white text-sm mb-1">Akurasi</p>
                <p class="text-3xl font-bold text-white">{{ number_format($metrik['akurasi'] * 100, 2) }}%</p>
                <p class="text-xs text-white mt-1">Total data: {{ $metrik['total_data'] }}</p>
            </div>

            <div
                class="bg-gradient-to-br from-green-500/20 to-green-600/20 backdrop-blur-md rounded-xl p-5 border border-green-400/30">
                <p class="text-white text-sm mb-1">Presisi</p>
                <p class="text-3xl font-bold text-white">{{ number_format($metrik['presisi'] * 100, 2) }}%</p>
            </div>

            <div
                class="bg-gradient-to-br from-purple-500/20 to-purple-600/20 backdrop-blur-md rounded-xl p-5 border border-purple-400/30">
                <p class="text-white text-sm mb-1">Recall</p>
                <p class="text-3xl font-bold text-white">{{ number_format($metrik['recall'] * 100, 2) }}%</p>
            </div>

            <div
                class="bg-gradient-to-br from-yellow-500/20 to-yellow-600/20 backdrop-blur-md rounded-xl p-5 border border-yellow-400/30">
                <p class="text-white text-sm mb-1">F1-Score</p>
                <p class="text-3xl font-bold text-white">{{ number_format($metrik['f1_score'] * 100, 2) }}%</p>
            </div>
        </div>

        <!-- Detail per Kelas -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl mb-6">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                <h2 class="text-lg font-bold text-white">Detail Per Kelas</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach (['K1', 'K2', 'K3', 'K4', 'K5'] as $kelas)
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full text-white
                        @if ($kelas == 'K1') bg-blue-500/50 border border-blue-300
                        @elseif($kelas == 'K2') bg-green-500/50 border border-green-300
                        @elseif($kelas == 'K3') bg-yellow-500/50 border border-yellow-300
                        @elseif($kelas == 'K4') bg-purple-500/50 border border-purple-300
                        @elseif($kelas == 'K5') bg-red-500/50 border border-red-300 @endif">
                                    {{ $kelas }}
                                </span>
                                <span class="text-white text-sm">
                                    TP: {{ $metrik['tp'][$kelas] ?? 0 }} |
                                    FP: {{ $metrik['fp'][$kelas] ?? 0 }} |
                                    FN: {{ $metrik['fn'][$kelas] ?? 0 }}
                                </span>
                            </div>
                            <div class="space-y-2">
                                @php
                                    $presisiKelas =
                                        $metrik['tp'][$kelas] + $metrik['fp'][$kelas] > 0
                                            ? $metrik['tp'][$kelas] / ($metrik['tp'][$kelas] + $metrik['fp'][$kelas])
                                            : 0;
                                    $recallKelas =
                                        $metrik['tp'][$kelas] + $metrik['fn'][$kelas] > 0
                                            ? $metrik['tp'][$kelas] / ($metrik['tp'][$kelas] + $metrik['fn'][$kelas])
                                            : 0;
                                @endphp
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Presisi:</span>
                                    <span
                                        class="text-white font-semibold">{{ number_format($presisiKelas * 100, 2) }}%</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Recall:</span>
                                    <span
                                        class="text-white font-semibold">{{ number_format($recallKelas * 100, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="bg-white-500/20 border border-yellow-400/30 rounded-xl p-5 mb-6">
            <p class="text-white text-center">Belum ada data yang dapat dievaluasi. Pastikan data uji memiliki kelas
                aktual dan sudah diprediksi.</p>
        </div>
    @endif

    <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
            <h2 class="text-lg font-bold text-white">Detail Hasil Prediksi per Data Uji</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">ID Uji</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Hasil Prediksi
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($dataUji as $index => $item)
                        <tr class="hover:bg-white/10 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white text-center">
                                {{ $dataUji->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-white text-center">{{ $item->id_uji }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($item->hasil_prediksi)
                                    <span
                                        class="px-3 py-1.5 text-xs font-bold rounded-full border-2 text-white
                                @if ($item->hasil_prediksi == 'K1') bg-blue-500/50 border-blue-300
                                @elseif($item->hasil_prediksi == 'K2') bg-green-500/50 border-green-300
                                @elseif($item->hasil_prediksi == 'K3') bg-yellow-500/50 border-yellow-300
                                @elseif($item->hasil_prediksi == 'K4') bg-purple-500/50 border-purple-300
                                @elseif($item->hasil_prediksi == 'K5') bg-red-500/50 border-red-300
                                @else bg-gray-500/50 border-gray-300 @endif">
                                        {{ $item->hasil_prediksi }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <a href="{{ route('prediksi.perhitungan', $item->id_uji) }}"
                                    class="inline-flex items-center gap-1 text-white hover:text-white transition-colors p-1.5 hover:bg-white/20 rounded-lg bg-white/10 border border-white/20"
                                    title="Detail Perhitungan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                                    <svg class="w-20 h-20 text-white/40 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-xl font-bold text-white mb-2">Belum ada hasil prediksi</p>
                                    <p class="text-white">Lakukan prediksi pada data uji terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($dataUji->hasPages())
            <div class="px-6 py-4 border-t border-white/20 bg-white/5">
                {{ $dataUji->links() }}
            </div>
        @endif
    </div>
@endsection
