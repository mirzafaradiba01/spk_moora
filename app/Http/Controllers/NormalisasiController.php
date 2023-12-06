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
                'alternatif.nama as alternatif_nama',
                'kriteriabobot.nama as kriteria_nama',
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

            $optimizationResults = $this->optimizedMoora($normalizedScores, $kriteriabobot);

            // Menghitung nilai akhir
            $hitungNilaiAkhir = $this->hitungNilaiAkhir($optimizationResults, $alternatif, $kriteriabobot);
            $hitungYi = $this->hitungYi($hitungNilaiAkhir);


            return view('normalisasi.index', compact('scores', 'kriteriabobot', 'alternatif', 'normalizedScores', 'optimizationResults', 'hitungNilaiAkhir','hitungYi'))->with('i', 0);
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

                // // Store the total optimization value for the current alternatif
                // $optimizationResults[$alternatifId]['totalOptimization'] = number_format($totalOptimization, 2);
            }

            return $optimizationResults;
        } catch (\Exception $e) {
            // Handle exception if needed
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function hitungNilaiAkhir($optimizationResults, $alternatif, $kriteriabobot)
{
    $hitungNilaiAkhir = [
        'benefit' => [],
        'cost' => [],
    ];

    // Iterasi melalui setiap alternatif
    foreach ($optimizationResults as $alternatifId => $optimizationData) {
        // Pastikan bahwa ID alternatif ada dalam array $alternatif
        if ($alternatif->contains('id', $alternatifId)) {
            $finalValueB = 0;
            $finalValueC = 0;

            foreach ($optimizationData as $kriteriaId => $optimizationValue) {
                if ($kriteriaId !== 'totalOptimization') {
                    // Tentukan jenis kriteria (benefit atau cost)
                    $tipeKriteria = $kriteriabobot->where('id', $kriteriaId)->first()->tipe;

                    // Untuk kriteria benefit, tambahkan nilai optimisasi langsung
                    // Untuk kriteria cost, kurangkan nilai optimisasi langsung
                    if ($tipeKriteria == 'benefit') {
                        $finalValueB += $optimizationValue;
                    } elseif ($tipeKriteria == 'cost') {
                        $finalValueC += $optimizationValue;
                    }
                }
            }

            // Simpan nilai akhir untuk alternatif saat ini
            $hitungNilaiAkhir['benefit'][$alternatifId] = number_format($finalValueB, 2);
            $hitungNilaiAkhir['cost'][$alternatifId] = number_format($finalValueC, 2);
        }
    }

    return $hitungNilaiAkhir;
}
public function hitungYi($hitungNilaiAkhir)
{
    $hitungYi = [];

    // Iterasi melalui setiap alternatif
    foreach ($hitungNilaiAkhir['benefit'] as $alternatifId => $benefitValue) {
        // Pastikan bahwa ID alternatif ada dalam array cost
        if (isset($hitungNilaiAkhir['cost'][$alternatifId])) {
            // Hitung nilai Yi (benefit - cost)
            $yiValue = $benefitValue - $hitungNilaiAkhir['cost'][$alternatifId];

            // Simpan nilai Yi untuk alternatif saat ini
            $hitungYi[$alternatifId]['yiValue'] = number_format($yiValue, 2);
        }
    }

    // Urutkan alternatif berdasarkan nilai Yi secara descending
    arsort($hitungYi);

    // Berikan ranking pada setiap alternatif
    $ranking = 1;
    foreach ($hitungYi as &$alternatif) {
        $alternatif['ranking'] = $ranking;
        $ranking++;
    }

    return $hitungYi;
}
public function showRanking()
{
    try {
        // Retrieve necessary data and calculations
        // For example, you may need to recalculate Yi values and rankings
        $scores = AlternatifSkor::select(
            'alternatifskor.id as ids',
            'alternatif.id as ida',
            'kriteriabobot.id as idk',
            'alternatifskor.score as score',
            'alternatif.nama as alternatif_nama',
            'kriteriabobot.nama as kriteria_nama',
            'kriteriabobot.tipe as tipe',
            'kriteriabobot.bobot as bobot',
            'kriteriabobot.description as description'
        )
            ->leftJoin('alternatif', 'alternatif.id', '=', 'alternatifskor.alternatif_id')
            ->leftJoin('kriteriabobot', 'kriteriabobot.id', '=', 'alternatifskor.kriteriabobot_id')
            ->get();

        $kriteriabobot = KriteriaBobotModel::get();
        $alternatif = AlternatifModel::get();

        $normalizedScores = $this->normalisasiMoora($scores, $kriteriabobot);
        $optimizationResults = $this->optimizedMoora($normalizedScores, $kriteriabobot);
        $hitungNilaiAkhir = $this->hitungNilaiAkhir($optimizationResults, $alternatif, $kriteriabobot);
        $hitungYi = $this->hitungYi($hitungNilaiAkhir);

        // Pass the necessary data to the ranking view
        return view('ranking', compact('scores', 'kriteriabobot', 'alternatif', 'normalizedScores', 'optimizationResults', 'hitungNilaiAkhir','hitungYi'));
    } catch (\Exception $e) {
        // Handle exception if needed
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}