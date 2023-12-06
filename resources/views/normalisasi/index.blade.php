@extends('layouts.index')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                
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
                            <h2>Normalisasi</h2>
                            <table id="mytable" class="display nowrap table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>
                                        @foreach ($kriteriabobot as $c)
                                            <th>{{$c->nama}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a)
                                    <tr>
                                        <td>{{$a->nama}}</td>
                                        @foreach ($normalizedScores[$a->id] as $normalizedScore)
                                            <td>{{ $normalizedScore }}</td>
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
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Normalisasi Terbobot</h2>
                            <table id="mytable" class="display nowrap table table-striped table-bordered">
                                <thead>
                                    <tr>
                                      
                                        <th>Alternatif</th>
                                        @foreach ($kriteriabobot as $k)
                                            <th>{{$k->nama}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $al)
                                    <tr>
                                       
                                        <td>{{$al->nama}}</td>
                                        @foreach ($normTerbobotResults[$al->id] as $result)
                                            <td>{{ $result }}</td>
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
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Nilai Optimasi</h2>
                            <table id="mytable" class="display nowrap table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>
                                        <th>MAX</th>
                                        <th>MIN</th>
                                        <th>Nilai Yi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hitungNilaiAkhir['benefit'] as $alternatifId => $benefitValue)
                                        <tr>
                                            <td>{{ $alternatif->where('id', $alternatifId)->first->nama['nama'] }}</td>
                                            <td>{{ $benefitValue }}</td>
                                            <td>
                                                @if (isset($hitungNilaiAkhir['cost'][$alternatifId]))
                                                    {{ $hitungNilaiAkhir['cost'][$alternatifId] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($hitungYi[$alternatifId]['yiValue']))
                                                    {{ $hitungYi[$alternatifId]['yiValue'] }}
                                                @endif
                                            </td>
                                            
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
