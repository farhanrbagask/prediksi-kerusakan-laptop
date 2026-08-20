<?php

namespace App\Http\Controllers;

use App\Models\DataLatih;
use App\Models\DataUji;
use App\Models\HasilPrediksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $naiveBayesService;

    public function __construct(\App\Services\NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        $totalDataLatih = DataLatih::count();
        $totalDataUji = DataUji::count();
        $totalPrediksi = HasilPrediksi::where('id_prediksi', '!=', 'METRIK')->count();

        $latestPrediksi = HasilPrediksi::where('id_prediksi', '!=', 'METRIK')
            ->with('dataUji')
            ->latest()
            ->take(5)
            ->get();

        $statistikKelas = DataLatih::select('kelas', \DB::raw('count(*) as total'))
            ->groupBy('kelas')
            ->get();

        // Get counts for actual labels in data_uji (Test Data)
        $aktualUji = DataUji::select('kelas', \DB::raw('count(*) as total'))
            ->whereNotNull('kelas')
            ->groupBy('kelas')
            ->pluck('total', 'kelas')
            ->toArray();

        // Get counts for predicted labels in data_uji (Test Data)
        $prediksiUji = DataUji::select('hasil_prediksi', \DB::raw('count(*) as total'))
            ->whereNotNull('hasil_prediksi')
            ->groupBy('hasil_prediksi')
            ->pluck('total', 'hasil_prediksi')
            ->toArray();

        $chartData = [
            'labels' => ['K1', 'K2', 'K3', 'K4', 'K5'],
            'nama_labels' => ['RAM/Memori', 'Hard Disk/SSD', 'LCD/Layar', 'Sistem Operasi', 'Overheating/Thermal'],
            'aktual' => [],
            'prediksi' => []
        ];

        foreach (['K1', 'K2', 'K3', 'K4', 'K5'] as $k) {
            $chartData['aktual'][] = $aktualUji[$k] ?? 0;
            $chartData['prediksi'][] = $prediksiUji[$k] ?? 0;
        }

        $metrik = $this->naiveBayesService->getMetrikEvaluasi();

        return view('dashboard', compact(
            'totalDataLatih',
            'totalDataUji',
            'totalPrediksi',
            'latestPrediksi',
            'statistikKelas',
            'metrik',
            'chartData'
        ));
    }
}
