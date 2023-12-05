<?php

namespace App\Http\Controllers;

use App\Models\AlternatifModel;
use App\Models\AlternatifSkor;
use App\Models\KriteriaBobotModel;
use Illuminate\Http\Request;

class DecisionMatrixController extends Controller
{
    public function index()
    {
        $alternatif = AlternatifModel::all();
        $kriteriabobot = KriteriaBobotModel::all();
        $score = AlternatifSkor::with(['alternatif', 'kriteriabobot'])->get();

        return view('decisionmatrix.index', compact('alternatif', 'kriteriabobot', 'score'));
    }

}
