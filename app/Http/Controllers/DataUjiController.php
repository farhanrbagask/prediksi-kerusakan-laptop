<?php

namespace App\Http\Controllers;

use App\Models\DataUji;
use App\Services\NaiveBayesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\HasilPrediksi;

class DataUjiController extends Controller
{
    protected $naiveBayesService;

    public function __construct(NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        $dataUji = DataUji::with('hasilPrediksi')->paginate(10);
        return view('data-uji.index', compact('dataUji'));
    }

    public function create()
    {
        return view('data-uji.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'layar_blank' => 'required|in:1,2',
            'layar_bergaris' => 'required|in:1,2',
            'auto_restart' => 'required|in:1,2',
            'boot_loop' => 'required|in:1,2',
            'alarm_bios' => 'required|in:1,2',
            'error_disk' => 'required|in:1,2',
            'keyboard_touchpad_mati' => 'required|in:1,2',
            'baterai_cepat_habis' => 'required|in:1,2',
            'overheat' => 'required|in:1,2',
            'hang' => 'required|in:1,2',
            'kelas' => 'required|in:K1,K2,K3,K4,K5'
        ]);

        $id = $this->naiveBayesService->generateId('UJ', 'data_uji', 'id_uji', 10);

        DataUji::create(array_merge(
            ['id_uji' => $id],
            $request->all()
        ));

        return redirect()->route('data-uji.index')
            ->with('success', 'Data uji berhasil ditambahkan');
    }

    public function edit($id)
    {
        $dataUji = DataUji::findOrFail($id);
        return view('data-uji.edit', compact('dataUji'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'layar_blank' => 'required|in:1,2',
            'layar_bergaris' => 'required|in:1,2',
            'auto_restart' => 'required|in:1,2',
            'boot_loop' => 'required|in:1,2',
            'alarm_bios' => 'required|in:1,2',
            'error_disk' => 'required|in:1,2',
            'keyboard_touchpad_mati' => 'required|in:1,2',
            'baterai_cepat_habis' => 'required|in:1,2',
            'overheat' => 'required|in:1,2',
            'hang' => 'required|in:1,2',
            'kelas' => 'required|in:K1,K2,K3,K4,K5'
        ]);

        $dataUji = DataUji::findOrFail($id);
        $dataUji->update($request->all());

        return redirect()->route('data-uji.index')
            ->with('success', 'Data uji berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dataUji = DataUji::findOrFail($id);
        $dataUji->hasilPrediksi()->delete();
        $dataUji->delete();

        $this->naiveBayesService->hitungMetrikEvaluasi();

        return redirect()->route('data-uji.index')
            ->with('success', 'Data uji berhasil dihapus');
    }

    /**
     * Import data dari file Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120'
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            array_shift($rows);

            $success = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                if (empty(array_filter($row))) {
                    continue;
                }

                try {
                    if (count($row) < 12) {
                        throw new \Exception("Baris " . ($index + 2) . ": Jumlah kolom tidak lengkap");
                    }

                    $convertValue = function ($value) {
                        if (is_numeric($value)) {
                            return (string)$value;
                        }

                        $value = strtolower(trim($value));
                        if ($value === 'ya' || $value === '2' || $value === 'yes' || $value === 'true') {
                            return '2';
                        }
                        if ($value === 'tidak' || $value === '1' || $value === 'no' || $value === 'false' || $value === '') {
                            return '1';
                        }

                        return '1';
                    };

                    $layar_blank = $convertValue($row[1] ?? '');
                    $layar_bergaris = $convertValue($row[2] ?? '');
                    $auto_restart = $convertValue($row[3] ?? '');
                    $boot_loop = $convertValue($row[4] ?? '');
                    $alarm_bios = $convertValue($row[5] ?? '');
                    $error_disk = $convertValue($row[6] ?? '');
                    $keyboard_touchpad_mati = $convertValue($row[7] ?? '');
                    $baterai_cepat_habis = $convertValue($row[8] ?? '');
                    $overheat = $convertValue($row[9] ?? '');
                    $hang = $convertValue($row[10] ?? '');

                    $kelas = strtoupper(trim($row[11] ?? ''));
                    if (empty($kelas) || !in_array($kelas, ['K1', 'K2', 'K3', 'K4', 'K5'])) {
                        throw new \Exception("Baris " . ($index + 2) . ": Kolom kelas (aktual) wajib diisi (K1-K5)");
                    }

                    if (!in_array($layar_blank, ['1', '2'])) $layar_blank = '1';
                    if (!in_array($layar_bergaris, ['1', '2'])) $layar_bergaris = '1';
                    if (!in_array($auto_restart, ['1', '2'])) $auto_restart = '1';
                    if (!in_array($boot_loop, ['1', '2'])) $boot_loop = '1';
                    if (!in_array($alarm_bios, ['1', '2'])) $alarm_bios = '1';
                    if (!in_array($error_disk, ['1', '2'])) $error_disk = '1';
                    if (!in_array($keyboard_touchpad_mati, ['1', '2'])) $keyboard_touchpad_mati = '1';
                    if (!in_array($baterai_cepat_habis, ['1', '2'])) $baterai_cepat_habis = '1';
                    if (!in_array($overheat, ['1', '2'])) $overheat = '1';
                    if (!in_array($hang, ['1', '2'])) $hang = '1';

                    $id = $this->naiveBayesService->generateId('UJ', 'data_uji', 'id_uji', 10);

                    DataUji::create([
                        'id_uji' => $id,
                        'layar_blank' => $layar_blank,
                        'layar_bergaris' => $layar_bergaris,
                        'auto_restart' => $auto_restart,
                        'boot_loop' => $boot_loop,
                        'alarm_bios' => $alarm_bios,
                        'error_disk' => $error_disk,
                        'keyboard_touchpad_mati' => $keyboard_touchpad_mati,
                        'baterai_cepat_habis' => $baterai_cepat_habis,
                        'overheat' => $overheat,
                        'hang' => $hang,
                        'kelas' => $kelas
                    ]);

                    $success++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "Berhasil mengimport $success data";
            if (!empty($errors)) {
                $message .= ". Gagal: " . implode("; ", array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $message .= " dan " . (count($errors) - 5) . " error lainnya";
                }
            }

            return redirect()->route('data-uji.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data-uji.index')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk data uji
     */
    public function template()
    {
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $headers = [
                'No',
                'X1 (Layar Blank)',
                'X2 (Layar Bergaris)',
                'X3 (Auto Restart)',
                'X4 (Boot Loop)',
                'X5 (Alarm BIOS)',
                'X6 (Error Disk)',
                'X7 (Keyboard/Touchpad Mati)',
                'X8 (Baterai Cepat Habis)',
                'X9 (Overheat)',
                'X10 (Hang)',
                'Kelas (Wajib)'
            ];

            foreach ($headers as $col => $header) {
                $columnLetter = chr(65 + $col);
                $sheet->setCellValue($columnLetter . '1', $header);
            }

            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];

            $sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

            $exampleData = [
                [
                    1,
                    '1',
                    '2',
                    '1',
                    '1',
                    '2',
                    '1',
                    '2',
                    '1',
                    '2',
                    '1',
                    'K1'
                ],
                [
                    2,
                    '2',
                    '1',
                    '2',
                    '1',
                    '1',
                    '2',
                    '1',
                    '1',
                    '2',
                    '1',
                    'K2'
                ]
            ];

            $row = 2;
            foreach ($exampleData as $data) {
                for ($col = 0; $col < count($data); $col++) {
                    $columnLetter = chr(65 + $col);
                    $sheet->setCellValue($columnLetter . $row, $data[$col]);
                }
                $row++;
            }

            foreach (range('A', 'L') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $infoRow = $row + 2;
            $sheet->setCellValue('A' . $infoRow, 'PETUNJUK PENGISIAN:');
            $sheet->getStyle('A' . $infoRow)->getFont()->setBold(true);

            $infoRow++;
            $sheet->setCellValue('A' . $infoRow, '1. Isi dengan angka:');
            $infoRow++;
            $sheet->setCellValue('A' . $infoRow, '   - 1 = Tidak mengalami gejala');
            $infoRow++;
            $sheet->setCellValue('A' . $infoRow, '   - 2 = Ya, mengalami gejala');
            $infoRow++;
            $sheet->setCellValue('A' . $infoRow, '2. Kolom Kelas (Wajib): K1, K2, K3, K4, atau K5');
            $infoRow++;
            $sheet->setCellValue('A' . $infoRow, '   - Menentukan label aktual dari data uji');
            $infoRow += 2;
            $sheet->setCellValue('A' . $infoRow, 'CATATAN: Gunakan angka 1 atau 2 untuk gejala!');

            $writer = new Xlsx($spreadsheet);
            $filename = 'template_data_uji.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            return redirect()->route('data-uji.index')
                ->with('error', 'Gagal membuat template: ' . $e->getMessage());
        }
    }

    /**
     * Hapus semua data uji
     */
    public function truncate()
    {
        try {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                DB::statement('PRAGMA foreign_keys = OFF');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
            }

            \App\Models\HasilPrediksi::truncate();
            DataUji::truncate();

            if ($driver === 'sqlite') {
                DB::statement('PRAGMA foreign_keys = ON');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }

            return redirect()->route('data-uji.index')
                ->with('success', 'Semua data uji berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('data-uji.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Prediksi semua data dengan created_at terakhir
     */
    public function prediksiTerakhir()
    {
        try {
            DB::beginTransaction();

            $lastDate = DataUji::max('created_at');

            if (!$lastDate) {
                return redirect()->route('data-uji.index')
                    ->with('error', 'Tidak ada data uji untuk diprediksi');
            }

            $lastDate = \Carbon\Carbon::parse($lastDate);

            $dataTerakhir = DataUji::whereDate('created_at', $lastDate->toDateString())
                ->get();

            if ($dataTerakhir->isEmpty()) {
                return redirect()->route('data-uji.index')
                    ->with('error', 'Tidak ada data uji terakhir yang ditemukan');
            }

            $berhasil = 0;
            $sudahDiprediksi = 0;
            $hasil = [];

            foreach ($dataTerakhir as $data) {
                if ($data->hasil_prediksi) {
                    $sudahDiprediksi++;
                    $hasil[] = $data->id_uji . ' (sudah: ' . $data->hasil_prediksi . ')';
                    continue;
                }

                $prediksi = $this->naiveBayesService->prediksiSatuData($data);

                $data->update([
                    'hasil_prediksi' => $prediksi['kelas']
                ]);

                $existing = HasilPrediksi::where('data_uji_id', $data->id_uji)->first();
                if (!$existing) {
                    $idPrediksi = $this->naiveBayesService->generateId('PR', 'hasil_prediksi', 'id_prediksi', 10);
                    HasilPrediksi::create([
                        'id_prediksi' => $idPrediksi,
                        'data_uji_id' => $data->id_uji,
                    ]);
                }

                $berhasil++;
                $hasil[] = $data->id_uji . ' (' . $prediksi['kelas'] . ')';
            }

            if ($berhasil > 0) {
                $this->naiveBayesService->hitungMetrikEvaluasi();
            }

            DB::commit();

            $message = "Berhasil memprediksi $berhasil data terakhir";
            if ($sudahDiprediksi > 0) {
                $message .= ". $sudahDiprediksi data sudah diprediksi sebelumnya";
            }
            $message .= ". Detail: " . implode(', ', $hasil);

            return redirect()->route('data-uji.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('data-uji.index')
                ->with('error', 'Gagal melakukan prediksi data terakhir: ' . $e->getMessage());
        }
    }
}
