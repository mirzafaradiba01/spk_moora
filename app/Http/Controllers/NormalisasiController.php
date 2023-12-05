<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use App\Models\AlternatifSkor;
use App\Models\KriteriaBobotModel;
use Illuminate\Http\Request;

class NormalisasiController extends Controller
{
    public function index()
    {
        try {
            // Mengambil semua skor alternatif beserta informasi terkait
            $score = AlternatifSkor::select(
                'alternatifskor.id as ids',
                'alternatif.id as ida',
                'kriteriabobot.id as idk',
                'alternatifskor.score as score',
                'kriteriabobot.nama as nama',
                'kriteriabobot.tipe as tipe',
                'kriteriabobot.bobot as bobot',
                'kriteriabobot.description as description'
            )
                ->leftJoin('alternatif', 'alternatif.id', '=', 'alternatifskor.alternatif_id')
                ->leftJoin('kriteriabobot', 'kriteriabobot.id', '=', 'alternatifskor.kriteriabobot_id')
                ->get();

            // Mengambil semua alternatif
            $alternatif = AlternatifModel::get();

            // Mengambil semua bobot kriteria
            $kriteriabobot = KriteriaBobotModel::get();

            // Normalisasi
            foreach ($alternatif as $a) {
                // Mengambil semua skor untuk setiap id alternatif
                $afilter = $score->where('ida', $a->id)->values()->all();

                // Looping setiap kriteria
                foreach ($kriteriabobot as $icw => $cw) {
                    // Menggunakan filter untuk menghilangkan nilai null
                    $rates = $score
                        ->filter(function ($val) use ($cw) {
                            return $cw->id == $val->idk;
                        })
                        ->map->score // Mengambil nilai score setelah filter
                        ->values() // Mengatur ulang kembali array keys
                        ->toArray();

                    // Menghapus nilai null yang dihasilkan oleh map,
                    // Mengindeks ulang array
                    $rates = array_values(array_filter($rates));

                    $total = 0;
                    foreach ($rates as $value) {
                        $total += pow($value, 2);
                    }

                    $sqrt = sqrt($total);

                    // Pengecekan sebelum melakukan pembagian
                    if ($sqrt != 0) {
                        // Pengecekan apakah $afilter[$icw] tidak null
                        if (isset($afilter[$icw])) {
                            $normalisasi = $afilter[$icw]->score / $sqrt;
                            $result = number_format($normalisasi, 2, '.', '');
                            $afilter[$icw]->score = $result;
                        } else {
                            // Handle jika $afilter[$icw] bernilai null
                            // Misalnya, berikan nilai default atau lakukan tindakan yang sesuai
                            // Contoh: throw new \Exception("Data skor alternatif tidak sesuai untuk alternatif $a->id");
                        }
                    } else {
                        // Handle jika pembagian oleh nol terjadi
                        // Misalnya, berikan nilai default atau lakukan tindakan yang sesuai
                        if (isset($afilter[$icw])) {
                            $afilter[$icw]->score = 0;
                        }
                    }
                }
            }

            return view('normalisasi.index', compact('score', 'alternatif', 'kriteriabobot'))->with('i', 0);
        } catch (\Exception $e) {
            // Handle exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
