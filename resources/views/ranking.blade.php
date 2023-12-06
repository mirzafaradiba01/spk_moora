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
                            
                                <h2 class="m-0">Perankingan</h2>
                            
                            <table id="rankingTable" class="display nowrap table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Alternatif</th>
                                        <th>Yi Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hitungYi as $alternatifId => $alternatifData)
                                        <tr>
                                            <td>{{ $alternatifData['ranking'] }}</td>
                                            <td>{{ $alternatif->where('id', $alternatifId)->first->nama['nama'] }}</td>
                                            <td>
                                                @if (isset($alternatifData['yiValue']))
                                                    {{ $alternatifData['yiValue'] }}
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
        $('#rankingTable').DataTable({
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
