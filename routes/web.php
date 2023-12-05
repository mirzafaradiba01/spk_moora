<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DecisionMatrixController;
use App\Http\Controllers\KriteriabobotController;
use App\Http\Controllers\NormalisasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index']);

Route::resources([
    'alternatif' => AlternatifController::class,
    'kriteriabobot' => KriteriabobotController::class,
    'decisionmatrix' => DecisionMatrixController::class,

]);

Route::get('normalization', [NormalisasiController::class, 'index']);




