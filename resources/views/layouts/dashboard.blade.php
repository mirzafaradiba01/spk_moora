@extends('layouts.index')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="card-title">Selamat Datang di Sistem Pendukung Keputusan</h2>
                                <i class="fas fa-lightbulb fa-3x"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="lead text-white">
                                Sistem ini dapat membantu Anda dalam pengambilan keputusan menggunakan Metode MOORA.
                            </p>
                            <p class="text-white">Metode ini diperkenalkan oleh Brauers pada tahun 2004 sebagai “Multi-Objective Optimization”. 
                                Metode yang digunakan untuk mengevaluasi beberapa alternatif dalam sistem multi-kriteria. 
                                Menentukan pilihan terbaik yang dioptimalkan berdasarkan kriteria yang diinginkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-gradient-success">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="card-title text-white">Cara Penggunaan dalam pengambilan keputusan menggunakan Metode MOORA</h2>
                                <i class="fas fa-info-circle fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <ol class="text-white">
                                <li>Masuk ke menu "Kriteria & Bobot" untuk menambahkan kriteria beserta bobotnya.</li>
                                <li>Gunakan menu "Alternatif & Skor" untuk menambahkan alternatif dan nilai skornya.</li>
                                <li>Masuk ke menu "Matriks Keputusan" untuk melihat representasi matriks dari nilai skor alternatif pada setiap kriteria.</li>
                                <li>Masuk ke menu "Perhitungann MOORA" untuk melakukan proses perhitungan normalisasi matriks keputusan, normalisasi terbobot, dan optimasi nilai Yi.</li>
                                <li>Cek menu "Ranking" untuk melihat hasilnya.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
