@extends('layouts.index')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Kriteria Baru</h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Ups!</strong> Ada beberapa masalah dengan masukan Anda.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{route('kriteriabobot.store')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Kode</label>
                                    <div class="input-group">
                                        <input id="nama" type="text" class="form-control" placeholder="Contoh: C1" name="nama" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    <select class="form-control" id="tipe" name="tipe">
                                        <option value="benefit">Benefit</option>
                                        <option value="cost">Cost</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <div class="input-group">
                                        <input id="bobot" type="text" class="form-control" placeholder="Contoh: 0.15" name="bobot" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <div class="input-group">
                                        <input id="description" type="text" class="form-control" placeholder="Contoh: Absensi" name="description" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('kriteriabobot.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
