@extends('layouts.master')

@section('header')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@stop
@section('content')
<div class="main">

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
         @if(session('sukses'))
            <div class="alert alert-success" role="alert">
                {{session('sukses')}}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
            @endif
            <div class="panel panel-profile">
                <div class="clearfix">
                    <!-- LEFT COLUMN -->
                    <div class="profile-left">

                        <!-- PROFILE HEADER -->
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <div class="profile-main">
                                <img src="{{$siswa->getAvatar()}}" class="img-circle" alt="Avatar">
                                <h3 class="name">{{$siswa->nama_depan}}</h3>
                                <span class="online-status status-available">Available</span>
                            </div>
                            <div class="profile-stat">
                                <div class="row">
                                    <div class="col-md-4 stat-item">
                                       {{$siswa->mapel->count()}}<span>Mata Pelajaran</span>
                                    </div>
                                    <div class="col-md-4 stat-item">
                                        15 <span>Awards</span>
                                    </div>
                                    <div class="col-md-4 stat-item">
                                        2174 <span>Points</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE HEADER -->

                        <!-- PROFILE DETAIL -->
                        <div class="profile-detail">
                            <div class="profile-info">
                                <h4 class="heading">Data Siswa</h4>
                                <ul class="list-unstyled list-justify">
                                    <li>Jenis Kelamin <span>{{$siswa->jenis_kelamin}}</span></li>
                                    <li>Agama <span>{{$siswa->agama}}</span></li>
                                    <li>Alamat <span>{{$siswa->alamat}}</span></li>
                                </ul>
                            </div>

                            <div class="text-center"><a href="/siswa/{{$siswa->id}}/edit" class="btn btn-warning">Edit Profile</a></div>
                        </div>
                        <!-- END PROFILE DETAIL -->
                    </div>
                    <!-- END LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="profile-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Tambah Nilai
                        </button>
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Mata Pelajaran</h3></div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>KODE</th>
                                                <th>NAMA</th>
                                                <th>SEMESTER</th>
                                                <th>NILAI</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($siswa->mapel as $mapel)
                                            <tr>
                                                <td>{{$mapel->kode}}</td>
                                                <td>{{$mapel->nama}}</td>
                                                <td>{{$mapel->semester}}</td>
                                                <td><a href="#" class="nilai" data-type="number" data-pk="{{$mapel->id}}" data-url="/api/siswa/{{$siswa->id}}/editnilai" data-title="Masukan Nilai">{{$mapel->pivot->nilai}}</a></td>
                                                <td>
                                            <a href="/siswa/{{$siswa->id}}/{{$mapel->id}}/deletenilai" class="btn btn-danger btn-sm" onclick="return confirm('Yakin data ini akan dihapus?')">Delete</a>
                                        </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        <dic class="panel">
                            <div id="chartNilai"></div>
                        </div>
                    </div>
                    <!-- END RIGHT COLUMN -->
                </div>
            </div>

        </div>
    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Nilai</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="/siswa/{{$siswa->id}}/addnilai" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="mapel">Mata Pelajaran</label>
                        <select class="form-control" id="mapel" name="mapel">
                        @foreach($matapelajaran as $mp)
                            <option value="{{$mp->id}}">{{$mp->nama}}</option>
                        @endforeach
                        </select>
                    </div>
            <div class="form-group{{$errors->has('nama_depan') ? ' has-error' : ''}}">
                <label for="exampleInputemail1">Nilai</label>
                <input name="nilai" type="text" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp" placeholder="Nilai" value="{{old('nilai')}}"> 
                @if($errors->has('nilai'))
                <span class="help-block">{{$errors->first('nilai')}}</span>
                @endif 
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>  
        </div>
        </div>
    </div>
    </div>
@stop
<!-- javascript -->
@section('footer')
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script>
    Highcharts.chart('chartNilai', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Laporan Nilai Siswa'
    },
    xAxis: {
        categories: {!!json_encode($categories)!!},
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Nilai'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Nilai',
        data: {!!json_encode($data)!!}

    }]
});

$(document).ready(function() {
    $('.nilai').editable();
});
</script>
@stop