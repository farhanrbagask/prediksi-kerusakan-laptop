<?php

namespace App\Services;

use App\Models\DataLatih;
use App\Models\DataUji;
use App\Models\HasilPrediksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NaiveBayesService
{
    private $atribut = [
        'layar_blank',
        'layar_bergaris',
        'auto_restart',
        'boot_loop',
        'alarm_bios',
        'error_disk',
        'keyboard_touchpad_mati',
        'baterai_cepat_habis',
        'overheat',
        'hang'
    ];

    private $kelas = ['K1', 'K2', 'K3', 'K4', 'K5'];

    private $namaKelas = [
        'K1' => 'Kerusakan RAM/Memori',
        'K2' => 'Kerusakan Hard Disk/SSD',
        'K3' => 'Kerusakan LCD/Layar',
        'K4' => 'Kerusakan Sistem Operasi',
        'K5' => 'Kerusakan akibat Overheating/Thermal'
    ];

    /**
     * Menghitung probabilitas prior untuk setiap atribut
     */
    public function hitungProbabilitasPrior()
    {
        $probabilitas = [];

        foreach ($this->atribut as $atr) {
            $probabilitas[$atr] = [];

            foreach ($this->kelas as $k) {
                $probabilitas[$atr][$k] = [
                    '1' => $this->hitungProbabilitasVariasi($atr, $k, '1'),
                    '2' => $this->hitungProbabilitasVariasi($atr, $k, '2')
                ];
            }
        }

        return $probabilitas;
    }

    /**
     * Menghitung probabilitas untuk variasi tertentu
     */
    private function hitungProbabilitasVariasi($atribut, $kelas, $nilai)
    {
        $totalKelas = DataLatih::where('kelas', $kelas)->count();

        if ($totalKelas == 0) {
            return 0;
        }

        $jumlah = DataLatih::where('kelas', $kelas)
            ->where($atribut, $nilai)
            ->count();

        return ($jumlah + 1) / ($totalKelas + 2);
    }

    /**
     * Memprediksi kelas untuk satu data uji
     */
    public function prediksiSatuData($dataUji)
    {
        $probabilitasPriorKelas = $this->hitungPriorKelas();
        $probabilitasPosterior = [];

        foreach ($this->kelas as $kelas) {
            $prob = $probabilitasPriorKelas[$kelas];

            foreach ($this->atribut as $atr) {
                $nilai = $dataUji->$atr;
                $probabilitasAtribut = $this->hitungProbabilitasVariasi($atr, $kelas, $nilai);
                $prob *= $probabilitasAtribut;
            }

            $probabilitasPosterior[$kelas] = $prob;
        }

        $total = array_sum($probabilitasPosterior);
        if ($total > 0) {
            foreach ($probabilitasPosterior as $kelas => $prob) {
                $probabilitasPosterior[$kelas] = $prob / $total;
            }
        }

        arsort($probabilitasPosterior);
        $hasilKelas = key($probabilitasPosterior);

        return [
            'kelas' => $hasilKelas,
            'probabilitas' => $probabilitasPosterior,
            'nama_kelas' => $this->namaKelas[$hasilKelas]
        ];
    }

    /**
     * Menghitung prior untuk setiap kelas
     */
    public function hitungPriorKelas()
    {
        $total = DataLatih::count();
        $prior = [];

        foreach ($this->kelas as $kelas) {
            $jumlah = DataLatih::where('kelas', $kelas)->count();
            $prior[$kelas] = ($jumlah + 1) / ($total + count($this->kelas));
        }

        return $prior;
    }

    /**
     * Menjalankan prediksi untuk semua data uji
     */
    public function prediksiSemuaData()
    {
        $dataUji = DataUji::all();
        $hasil = [];

        foreach ($dataUji as $uji) {
            $prediksi = $this->prediksiSatuData($uji);

            $hasil[] = [
                'data_uji' => $uji,
                'prediksi' => $prediksi
            ];
        }

        return $hasil;
    }

    public function hitungMetrikEvaluasi()
    {
        $dataUji = DataUji::whereNotNull('kelas')
            ->whereNotNull('hasil_prediksi')
            ->get();

        $total = $dataUji->count();
        if ($total == 0) {
            HasilPrediksi::updateOrCreate(
                ['id_prediksi' => 'METRIK'],
                [
                    'akurasi' => 0,
                    'presisi' => 0,
                    'recall' => 0,
                    'f1_score' => 0
                ]
            );
            return [
                'akurasi' => 0,
                'presisi' => 0,
                'recall' => 0,
                'f1_score' => 0,
                'total_data' => 0
            ];
        }

        $tp = [];
        $fp = [];
        $fn = [];

        foreach ($this->kelas as $kelas) {
            $tp[$kelas] = 0;
            $fp[$kelas] = 0;
            $fn[$kelas] = 0;
        }

        foreach ($dataUji as $uji) {
            $aktual = $uji->kelas;
            $prediksi = $uji->hasil_prediksi;

            if ($aktual && $prediksi) {
                if ($aktual == $prediksi) {
                    $tp[$aktual]++;
                } else {
                    $fp[$prediksi]++;
                    $fn[$aktual]++;
                }
            }
        }

        $totalBenar = array_sum($tp);
        $akurasi = $total > 0 ? $totalBenar / $total : 0;

        $presisiTotal = 0;
        $recallTotal = 0;
        $countKelas = 0;

        foreach ($this->kelas as $kelas) {
            $presisiKelas = ($tp[$kelas] + $fp[$kelas]) > 0 ?
                $tp[$kelas] / ($tp[$kelas] + $fp[$kelas]) : 0;

            $recallKelas = ($tp[$kelas] + $fn[$kelas]) > 0 ?
                $tp[$kelas] / ($tp[$kelas] + $fn[$kelas]) : 0;

            if ($tp[$kelas] > 0 || $fp[$kelas] > 0 || $fn[$kelas] > 0) {
                $presisiTotal += $presisiKelas;
                $recallTotal += $recallKelas;
                $countKelas++;
            }
        }

        $presisi = $countKelas > 0 ? $presisiTotal / $countKelas : 0;
        $recall = $countKelas > 0 ? $recallTotal / $countKelas : 0;
        $f1Score = ($presisi + $recall) > 0 ?
            2 * ($presisi * $recall) / ($presisi + $recall) : 0;

        HasilPrediksi::updateOrCreate(
            ['id_prediksi' => 'METRIK'],
            [
                'akurasi' => $akurasi,
                'presisi' => $presisi,
                'recall' => $recall,
                'f1_score' => $f1Score
            ]
        );

        return [
            'akurasi' => $akurasi,
            'presisi' => $presisi,
            'recall' => $recall,
            'f1_score' => $f1Score,
            'tp' => $tp,
            'fp' => $fp,
            'fn' => $fn,
            'total_benar' => $totalBenar,
            'total_data' => $total
        ];
    }

    public function getMetrikEvaluasi()
    {
        $metrik = HasilPrediksi::where('id_prediksi', 'METRIK')->first();

        if (!$metrik) {
            return $this->hitungMetrikEvaluasi();
        }

        $totalData = DataUji::whereNotNull('kelas')
            ->whereNotNull('hasil_prediksi')
            ->count();

        $dataUji = DataUji::whereNotNull('kelas')
            ->whereNotNull('hasil_prediksi')
            ->get();

        $tp = [];
        $fp = [];
        $fn = [];

        foreach ($this->kelas as $kelas) {
            $tp[$kelas] = 0;
            $fp[$kelas] = 0;
            $fn[$kelas] = 0;
        }

        foreach ($dataUji as $uji) {
            $aktual = $uji->kelas;
            $prediksi = $uji->hasil_prediksi;

            if ($aktual == $prediksi) {
                $tp[$aktual]++;
            } else {
                $fp[$prediksi]++;
                $fn[$aktual]++;
            }
        }

        return [
            'akurasi' => $metrik->akurasi,
            'presisi' => $metrik->presisi,
            'recall' => $metrik->recall,
            'f1_score' => $metrik->f1_score,
            'tp' => $tp,
            'fp' => $fp,
            'fn' => $fn,
            'total_data' => $totalData
        ];
    }

    /**
     * Mendapatkan daftar atribut
     */
    public function getAtribut()
    {
        return $this->atribut;
    }

    /**
     * Mendapatkan nama kelas
     */
    public function getNamaKelas($kode)
    {
        return $this->namaKelas[$kode] ?? $kode;
    }

    /**
     * Mendapatkan probabilitas untuk ditampilkan dalam tabel
     */
    public function getProbabilitasTabel()
    {
        $probabilitas = $this->hitungProbabilitasPrior();
        $tabel = [];

        foreach ($this->atribut as $index => $atr) {
            $namaAtribut = $this->getNamaAtribut($atr);
            $tabel[$atr] = [
                'nama' => $namaAtribut,
                'no' => $index + 2,
                'probabilitas' => []
            ];

            foreach ($this->kelas as $kelas) {
                $tabel[$atr]['probabilitas'][$kelas] = [
                    'tidak' => number_format($probabilitas[$atr][$kelas]['1'], 10),
                    'ya' => number_format($probabilitas[$atr][$kelas]['2'], 10)
                ];
            }
        }

        return $tabel;
    }

    /**
     * Mendapatkan nama atribut
     */
    private function getNamaAtribut($atribut)
    {
        $nama = [
            'layar_blank' => 'Layar tidak menampilkan gambar (gelap/blank)',
            'layar_bergaris' => 'Muncul garis-garis aneh (horizontal/vertikal) di layar',
            'auto_restart' => 'Laptop tiba-tiba mati atau restart sendiri',
            'boot_loop' => 'Laptop tidak bisa masuk Windows (boot loop)',
            'alarm_bios' => 'Terdengar suara bip berulang saat dihidupkan (alarm BIOS)',
            'error_disk' => 'Terdapat pesan eror terkait disk atau boot',
            'keyboard_touchpad_mati' => 'Keyboard atau touchpad tidak berfungsi sebagian/total',
            'baterai_cepat_habis' => 'Baterai cepat habis atau tidak bisa diisi daya',
            'overheat' => 'Laptop terasa sangat panas (overheating)',
            'hang' => 'Performa sangat lambat atau sering hang'
        ];

        return $nama[$atribut] ?? $atribut;
    }

    /**
     * Generate ID otomatis
     */
    public function generateId($prefix, $table, $column, $length = 10)
    {
        $lastRecord = DB::table($table)
            ->where($column, 'like', $prefix . '%')
            ->orderBy($column, 'desc')
            ->first();

        if ($lastRecord) {
            $lastId = substr($lastRecord->$column, strlen($prefix));
            $newId = (int)$lastId + 1;
            return $prefix . str_pad($newId, $length - strlen($prefix), '0', STR_PAD_LEFT);
        }

        return $prefix . str_pad('1', $length - strlen($prefix), '0', STR_PAD_LEFT);
    }
}
