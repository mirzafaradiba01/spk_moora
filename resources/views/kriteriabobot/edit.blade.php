@extends('layouts.index')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Kriteria</h1>
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
                            <form action="{{route('kriteriabobot.update', $kriteriabobot->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Kode</label>
                                    <div class="input-group">
                                        <input id="nama" type="text" class="form-control" placeholder="Contoh: C1" name="nama" value="{{ $kriteriabobot->nama }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    <select class="form-control" id="tipe" name="tipe">
                                        @if ($kriteriabobot->tipe == "benefit")
                                            <option value="benefit" selected='selected'>Benefit</option>
                                            <option value="cost">Cost</option>
                                        @else
                                            <option value="benefit">Benefit</option>
                                            <option value="cost" selected='selected'>Cost</option>
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <div class="input-group">
                                        <input id="bobot" type="text" class="form-control" placeholder="Contoh: 0.15" name="bobot" value="{{ $kriteriabobot->bobot }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <div class="input-group">
                                        <input id="description" type="text" class="form-control" placeholder="Contoh: Absensi" name="description" value="{{ $kriteriabobot->description }}" required>
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