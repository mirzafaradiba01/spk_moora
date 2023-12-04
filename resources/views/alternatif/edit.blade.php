@extends('layouts.index')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Penilaian Alternatif</h1>
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
                            <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <div class="input-group">
                                        <input id="nama" type="text" class="form-control" placeholder="Contoh: C1" name="nama" value="{{ $alternatif->nama }}" required>
                                    </div>
                                </div>
                                @foreach ($kriteriabobot as $key => $k)
                                    <div class="form-group">
                                        <label for="nama[{{ $k->id }}]">{{ $k->nama }} - {{ $k->description }}</label>
                                        <select class="form-control" id="nama[{{ $k->id }}]" name="nama[{{ $k->id }}]">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ isset($alternatifskor[$key]) && $i == $alternatifskor[$key]->value ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
