@extends('layouts.index')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Normalisasi</h1>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="mytable" class="display nowrap table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        @foreach ($kriteriabobot as $k)
                                        <th>{{$k->nama}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{$alternatif->nama}}</td>
                                        @php
                                        $alternatifskor = $score->where('alternatif_id', $alternatif->id)->all();
                                        @endphp
                                        @foreach ($alternatifskor as $score)
                                        <td>{{$score->score}}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $('#mytable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection
