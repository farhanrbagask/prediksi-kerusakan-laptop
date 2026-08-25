@extends('layouts.app')

@section('title', 'Detail Perhitungan Prediksi')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Detail Perhitungan Prediksi</h1>
        <p class="text-gray-400 text-sm mt-1">Perhitungan detail probabilitas untuk data uji {{ $dataUji->id_uji }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Data Uji -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                <h2 class="text-lg font-bold text-white">Data Uji</h2>
            </div>
            <div class="p-6">
                <table class="w-full">
                    <tr>
                        <td class="py-2 text-gray-400">ID Uji</td>
                        <td class="py-2 text-white font-mono">{{ $dataUji->id_uji }}</td>
                    </tr>
                    @foreach (['layar_blank', 'layar_bergaris', 'auto_restart', 'boot_loop', 'alarm_bios', 'error_disk', 'keyboard_touchpad_mati', 'baterai_cepat_habis', 'overheat', 'hang'] as $index => $atr)
                        <tr>
                            <td class="py-2 text-gray-400">X{{ $index + 1 }} - {{ ucfirst(str_replace('_', ' ', $atr)) }}
                            </td>
                            <td class="py-2">
                                <span
                                    class="px-2.5 py-1.5 bg-white/20 rounded-lg text-xs font-bold text-white border border-white/30">
                                    {{ $dataUji->$atr == '1' ? 'Tidak (1)' : 'Ya (2)' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="py-2 text-gray-400">Kelas Aktual</td>
                        <td class="py-2">
                            @if ($dataUji->kelas)
                                <span
                                    class="px-3 py-1.5 text-xs font-bold rounded-full border-2 text-white
                                @if ($dataUji->kelas == 'K1') bg-blue-500/50 border-blue-300
                                @elseif($dataUji->kelas == 'K2') bg-green-500/50 border-green-300
                                @elseif($dataUji->kelas == 'K3') bg-yellow-500/50 border-yellow-300
                                @elseif($dataUji->kelas == 'K4') bg-purple-500/50 border-purple-300
                                @elseif($dataUji->kelas == 'K5') bg-red-500/50 border-red-300 @endif">
                                    {{ $dataUji->kelas }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gray-400">Hasil Prediksi</td>
                        <td class="py-2">
                            <span
                                class="px-3 py-1.5 text-xs font-bold rounded-full border-2 text-white
                            @if ($dataUji->hasil_prediksi == 'K1') bg-blue-500/50 border-blue-300
                            @elseif($dataUji->hasil_prediksi == 'K2') bg-green-500/50 border-green-300
                            @elseif($dataUji->hasil_prediksi == 'K3') bg-yellow-500/50 border-yellow-300
                            @elseif($dataUji->hasil_prediksi == 'K4') bg-purple-500/50 border-purple-300
                            @elseif($dataUji->hasil_prediksi == 'K5') bg-red-500/50 border-red-300 @endif">
                                {{ $dataUji->hasil_prediksi }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Perhitungan per Kelas -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                <h2 class="text-lg font-bold text-white">Detail Perhitungan Probabilitas</h2>
            </div>
            <div class="p-6">
                @foreach ($detailPerhitungan as $kelas => $detail)
                    <div class="mb-6 last:mb-0">
                        <div class="flex items-center gap-2 mb-3">
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-full text-white
                        @if ($kelas == 'K1') bg-blue-500/50 border border-blue-300
                        @elseif($kelas == 'K2') bg-green-500/50 border border-green-300
                        @elseif($kelas == 'K3') bg-yellow-500/50 border border-yellow-300
                        @elseif($kelas == 'K4') bg-purple-500/50 border border-purple-300
                        @elseif($kelas == 'K5') bg-red-500/50 border border-red-300 @endif">
                                {{ $kelas }}
                            </span>
                            <span class="text-white text-sm">Prior: {{ number_format($detail['prior'], 10) }}</span>
                        </div>

                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            @foreach ($detail['perkalian'] as $item)
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-400">{{ $item['atribut'] }}
                                        ({{ $item['nilai'] == '1' ? 'Tidak' : 'Ya' }})
                                    </span>
                                    <span
                                        class="text-white font-mono">{{ number_format($item['probabilitas'], 10) }}</span>
                                </div>
                            @endforeach

                            <div class="border-t border-white/10 my-3 pt-3">
                                <div class="flex justify-between text-sm font-bold">
                                    <span class="text-white">Total (Prior × Semua Prob)</span>
                                    <span class="text-white">{{ number_format($detail['total'], 10) }}</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold mt-2">
                                    <span class="text-white">Normalisasi</span>
                                    <span class="text-white">{{ number_format($detail['normalisasi'] * 100, 4) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('prediksi.index') }}"
            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors border border-gray-300">
            Kembali ke Hasil Prediksi
        </a>
    </div>
@endsection
