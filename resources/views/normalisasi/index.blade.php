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
                                        @foreach ($optimizationResults[$al->id] as $result)
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
                            <h2>Benefit Values</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>
                                        <th>Benefit Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hitungNilaiAkhir['benefit'] as $alternatifId => $benefitValue)
                                        @if (isset($alternatif[$alternatifId]))
                                            <tr>
                                                <td>{{ $alternatif[$alternatifId]->nama }}</td>
                                                <td>{{ $benefitValue }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        
                            <!-- Display Cost Values -->
                            <h2>Cost Values</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Alternatif</th>
                                        <th>Cost Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hitungNilaiAkhir['cost'] as $alternatifId => $costValue)
                                        @if (isset($alternatif[$alternatifId]))
                                            <tr>
                                                <td>{{ $alternatif[$alternatifId]->nama }}</td>
                                                <td>{{ $costValue }}</td>
                                            </tr>
                                        @endif
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
