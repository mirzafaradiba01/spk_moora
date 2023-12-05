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

            // Normalisasi Moora
            foreach ($scores as $skor) {
                $skor->score = round(($akarKuadrat[$skor->idk] != 0) ? $skor->score / $akarKuadrat[$skor->idk] : 0, 2);
            }

            return view('normalisasi.index', compact('scores', 'kriteriabobot', 'alternatif'))->with('i', 0);
        } catch (\Exception $e) {
            // Handle exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
