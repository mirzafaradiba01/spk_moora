<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\AlternatifModel;
use App\Models\AlternatifSkor;
use App\Models\KriteriaBobotModel;
use Illuminate\Support\Facades\DB;

class NormalisasiController extends Controller
{
    public function index()
{
    try {
        // Mengambil semua skor alternatif beserta informasi terkait
        $scores = AlternatifSkor::select(
            'alternatifskor.id as ids',
            'alternatif.id as ida',
            'kriteriabobot.id as idk',
            'alternatifskor.score as score',
            'alternatif.nama as nama',
            'kriteriabobot.nama as nama',
            'kriteriabobot.tipe as tipe',
            'kriteriabobot.bobot as bobot',
            'kriteriabobot.description as description'
        )
            ->leftJoin('alternatif', 'alternatif.id', '=', 'alternatifskor.alternatif_id')
            ->leftJoin('kriteriabobot', 'kriteriabobot.id', '=', 'alternatifskor.kriteriabobot_id')
            ->get();

        // Mengambil semua kriteria bobot
        $kriteriabobot = KriteriaBobotModel::get();

        // Mengambil semua alternatif (you may need to adjust this based on your model)
        $alternatif = AlternatifModel::get();

        // Memanggil fungsi untuk normalisasi Moora
        $normalizedScores = $this->normalisasiMoora($scores, $kriteriabobot);

        $optimizationResults = $this->optimizedMoora($normalizedScores,$kriteriabobot);

       
       // Menghitung nilai akhir
       $hitungNilaiAkhir = $this->hitungNilaiAkhir($optimizationResults,$alternatif);

       

        return view('normalisasi.index', compact('scores', 'kriteriabobot', 'alternatif', 'normalizedScores','optimizationResults','hitungNilaiAkhir'))->with('i', 0);
    } catch (\Exception $e) {
        // Handle exception
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    // Fungsi untuk normalisasi Moora
private function normalisasiMoora(&$scores, $kriteriabobot)
{
    // Array untuk menyimpan total kuadrat setiap kriteria
    $totalKuadrat = [];

    // Perhitungan total kuadrat untuk setiap kriteria
    foreach ($kriteriabobot as $kriteria) {
        $totalKuadrat[$kriteria->id] = AlternatifSkor::where('kriteriabobot_id', $kriteria->id)
            ->sum(DB::raw('POWER(score, 2)'));
    }

    // Array untuk menyimpan akar kuadrat dari total kuadrat
    $akarKuadrat = [];

    // Perhitungan akar kuadrat dari total kuadrat
    foreach ($totalKuadrat as $kriteriaId => $total) {
        $akarKuadrat[$kriteriaId] = sqrt($total);
    }

    // Array untuk menyimpan hasil normalisasi
    $normalizedScores = [];
   
    // Normalisasi Moora
    foreach ($scores as $skor) {
        $normalizedScore = round(($akarKuadrat[$skor->idk] != 0) ? $skor->score / $akarKuadrat[$skor->idk] : 0, 2);

        // Menyimpan hasil normalisasi ke dalam array
        $normalizedScores[$skor->ida][$skor->idk] = $normalizedScore;

        // Jika Anda ingin menyimpan hasil normalisasi langsung pada objek $scores, bisa menggunakan baris berikut:
        // $skor->normalizedScore = $normalizedScore;
    }
    // Return the array of normalized scores if needed
    return $normalizedScores;
}

public function optimizedMoora($normalizedScores, $kriteriabobot)
{
    try {
        $optimizationResults = [];

        // Iterate through each alternatif
        foreach ($normalizedScores as $alternatifId => $normalizedScoresPerAlternatif) {
            // Initialize the total optimization for the current alternatif
            $totalOptimization = 0;

            // Iterate through each kriteria
            foreach ($normalizedScoresPerAlternatif as $kriteriaId => $normalizedScore) {
                // Find the corresponding weight (bobot) for the current kriteria
                $bobot = $kriteriabobot->where('id', $kriteriaId)->first()->bobot;

                // Ensure the kriteria ID is valid
                if ($bobot !== null) {
                    // Calculate the optimization value for the current kriteria
                    $optimizationValue = $normalizedScore * $bobot;

                    // Accumulate the optimization values for each kriteria
                    $totalOptimization += $optimizationValue;

                    // Optionally, you can store the formatted optimization values in an array
                    $optimizationResults[$alternatifId][$kriteriaId] = number_format($optimizationValue, 2);
                }
            }

            // Store the total optimization value for the current alternatif
            // $optimizationResults[$alternatifId]['totalOptimization'] = number_format($totalOptimization, 2);
        }

        return $optimizationResults;
    } catch (\Exception $e) {
        // Handle exception if needed
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



public function hitungNilaiAkhir($optimizationResults, $alternatif)
{
    $hitungNilaiAkhir = [
        'benefit' => [],
        'cost' => [],
    ];

    // Iterasi melalui setiap alternatif
    foreach ($optimizationResults as $alternatifId => $optimizationData) {
        // Pastikan bahwa ID alternatif ada dalam array $alternatif
        if (isset($alternatif[$alternatifId])) {
            // Inisialisasi nilai akhir untuk alternatif saat ini
            $finalValueBenefit = 0;
            $finalValueCost = 0;

            // Iterasi melalui setiap kriteria
            foreach ($optimizationData as $kriteriaId => $optimizationResult) {
                // Temukan data kriteria yang sesuai
                $kriteria = KriteriaBobotModel::find($kriteriaId);
                
                // Pastikan data kriteria valid
                if ($kriteria !== null) {
                    // Tentukan jenis kriteria (benefit atau cost)
                    if ($kriteria->tipe == 'benefit') {
                        // Untuk kriteria benefit, tambahkan nilai optimisasi langsung
                        $finalValueBenefit += $optimizationResult;
                    } elseif ($kriteria->tipe == 'cost') {
                        // Untuk kriteria cost, kurangkan nilai optimisasi langsung
                        $finalValueCost += $optimizationResult;
                    }
                } else {
                    // Log atau debug jika kriteria tidak ditemukan
                    // Ini membantu mengidentifikasi masalah dengan data atau query database
                    // Contoh: Log::error("Kriteria tidak ditemukan untuk ID: $kriteriaId");
                }
            }

            // Simpan nilai akhir untuk alternatif saat ini
            $hitungNilaiAkhir['benefit'][$alternatifId] = number_format($finalValueBenefit, 2);
            $hitungNilaiAkhir['cost'][$alternatifId] = number_format($finalValueCost, 2);
        } else {
            // Alternatif dengan ID di luar 1-4, tambahkan logika sesuai kebutuhan
            // Misalnya, Anda bisa menyimpan nilai default atau memberikan pesan kesalahan.
        }
    }

    // dd($hitungNilaiAkhir);

    return $hitungNilaiAkhir;
}



}
