<?php

namespace App\Http\Controllers;

use App\Models\DataUji;
use App\Models\HasilPrediksi;
use App\Services\NaiveBayesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrediksiController extends Controller
{
    protected $naiveBayesService;

    public function __construct(NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        $metrik = $this->naiveBayesService->getMetrikEvaluasi();
        $dataUji = DataUji::whereNotNull('hasil_prediksi')->paginate(10);

        return view('prediksi.index', compact('metrik', 'dataUji'));
    }

    public function prediksiSatu($id)
    {
        try {
            DB::beginTransaction();

            $dataUji = DataUji::findOrFail($id);

            $prediksi = $this->naiveBayesService->prediksiSatuData($dataUji);

            $dataUji->update([
                'hasil_prediksi' => $prediksi['kelas']
            ]);

            $existing = HasilPrediksi::where('data_uji_id', $dataUji->id_uji)->first();
            if (!$existing) {
                $idPrediksi = $this->naiveBayesService->generateId('PR', 'hasil_prediksi', 'id_prediksi', 10);
                HasilPrediksi::create([
                    'id_prediksi' => $idPrediksi,
                    'data_uji_id' => $dataUji->id_uji,
                ]);
            }

            $this->naiveBayesService->hitungMetrikEvaluasi();

            DB::commit();

            return redirect()->route('data-uji.index')
                ->with('success', 'Prediksi berhasil dilakukan. Hasil: ' . $prediksi['kelas'] . ' - ' . $prediksi['nama_kelas']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data-uji.index')
                ->with('error', 'Gagal melakukan prediksi: ' . $e->getMessage());
        }
    }

    public function prediksiSemua()
    {
        try {
            DB::beginTransaction();

            $dataUji = DataUji::all();

            if ($dataUji->isEmpty()) {
                return redirect()->route('data-uji.index')
                    ->with('error', 'Tidak ada data uji untuk diprediksi');
            }

            $hasil = [];
            foreach ($dataUji as $uji) {
                $prediksi = $this->naiveBayesService->prediksiSatuData($uji);

                $uji->update([
                    'hasil_prediksi' => $prediksi['kelas']
                ]);

                $existing = HasilPrediksi::where('data_uji_id', $uji->id_uji)->first();
                if (!$existing) {
                    $idPrediksi = $this->naiveBayesService->generateId('PR', 'hasil_prediksi', 'id_prediksi', 10);
                    HasilPrediksi::create([
                        'id_prediksi' => $idPrediksi,
                        'data_uji_id' => $uji->id_uji,
                    ]);
                }

                $hasil[] = $prediksi['kelas'];
            }

            $metrik = $this->naiveBayesService->hitungMetrikEvaluasi();

            DB::commit();

            return redirect()->route('data-uji.index')
                ->with('success', 'Berhasil melakukan prediksi untuk ' . count($dataUji) . ' data uji. Akurasi: ' . number_format($metrik['akurasi'] * 100, 2) . '%');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data-uji.index')
                ->with('error', 'Gagal melakukan prediksi: ' . $e->getMessage());
        }
    }

    public function perhitunganDetail($id)
    {
        $dataUji = DataUji::findOrFail($id);

        if (!$dataUji->hasil_prediksi) {
            return redirect()->route('prediksi.index')
                ->with('error', 'Data uji belum diprediksi');
        }

        $probabilitas = $this->naiveBayesService->hitungProbabilitasPrior();
        $priorKelas = $this->naiveBayesService->hitungPriorKelas();

        $detailPerhitungan = [];
        foreach (['K1', 'K2', 'K3', 'K4', 'K5'] as $kelas) {
            $prob = $priorKelas[$kelas];
            $perkalian = [];

            foreach ($this->naiveBayesService->getAtribut() as $atr) {
                $nilai = $dataUji->$atr;
                $probAtribut = $probabilitas[$atr][$kelas][$nilai];
                $prob *= $probAtribut;
                $perkalian[] = [
                    'atribut' => $atr,
                    'nilai' => $nilai,
                    'probabilitas' => $probAtribut
                ];
            }

            $detailPerhitungan[$kelas] = [
                'prior' => $priorKelas[$kelas],
                'perkalian' => $perkalian,
                'total' => $prob
            ];
        }

        $totalProb = array_sum(array_column($detailPerhitungan, 'total'));
        foreach ($detailPerhitungan as $kelas => &$detail) {
            $detail['normalisasi'] = $totalProb > 0 ? $detail['total'] / $totalProb : 0;
        }

        return view('prediksi.detail', compact('dataUji', 'detailPerhitungan'));
    }
}
