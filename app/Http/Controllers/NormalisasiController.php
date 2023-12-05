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
        // Mengambil semua skor alternatif beserta informasi terkait
        $scores = AlternatifSkor::select(
            'alternatifskor.id as id',
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
            $cscores = AlternatifSkor::select(
                'alternatifskor.id as id',
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
 $kriteriabobot= KriteriaBobotModel::get();

 // Normalisasi
 foreach ($alternatif as $a) {
     // Mengambil semua skor untuk setiap id alternatif
     $afilter = $scores->where('ida', $a->id)->values()->all();
     // Looping setiap kriteria
     foreach ($kriteriabobot as $icw => $cw) {
         // Mengambil semua nilai rating untuk setiap kriteria
         $rates = $cscores->map(function ($val) use ($cw) {
             if ($cw->id == $val->idw) {
                 return $val->score;
             }
         })->toArray();

         // Menghapus nilai null yang dihasilkan oleh map,
         // Mengindeks ulang array
         $rates = array_values(array_filter($rates));

         $total = 0;
         foreach ($rates as $value) {
             $total += pow($value, 2);
         }
         
         $sqrt = sqrt($total);
       
         $normalisasi = $afilter[$icw]->score / $sqrt;
         $result = number_format($normalisasi, 2, '.', '');
         $afilter[$icw]->score = $result;
     }
 }
 return view('normalisasi.index', compact('scores', 'alternatif', 'criteriaweights'))->with('i', 0);
    }
}
