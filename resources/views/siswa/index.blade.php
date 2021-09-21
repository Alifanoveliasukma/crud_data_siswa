@extends('layouts.master')

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Siswa</h3>
                            <div class="right">
                                <button type="button" class="btn-remove" data-toggle="modal" data-target="#exampleModal"><i class="lnr lnr-plus-circle"></i></button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NAMA DEPAN</th>
                                        <th>NAMA BELAKANG</th>
                                        <th>JENIS KELAMIN</th>
                                        <th>AGAMA</th>
                                        <th>ALAMAT</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_siswa as $siswa)
                                    <tr>
                                        <td><a href="/siswa/{{$siswa->id}}/profile">{{$siswa->nama_depan}}</a></td>
                                        <td><a href="/siswa/{{$siswa->id}}/profile">{{$siswa->nama_belakang}}</a></td>
                                        <td>{{$siswa->jenis_kelamin}}</td>
                                        <td>{{$siswa->agama}}</td>
                                        <td>{{$siswa->alamat}}</td>
                                        <td>
                                            <a href="/siswa/{{$siswa->id}}/edit" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="/siswa/{{$siswa->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin data ini akan dihapus?')">Delete</a>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/siswa/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group{{$errors->has('nama_depan') ? ' has-error' : ''}}">
                        <label for="exampleInputemail1">Nama Depan</label>
                        <input name="nama_depan" type="text" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp" placeholder="Nama Depan" value="{{old('nama_depan')}}"> 
                        @if($errors->has('nama_depan'))
                        <span class="help-block">{{$errors->first('nama_depan')}}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="exampleInputemail1">Nama Belakang</label>
                        <input name="nama_belakang" type="text" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp" placeholder="Nama Belakang" value="{{old('nama_belakang')}}">
                    </div>

                    <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                        <label for="exampleInputemail1">Email</label>
                        <input name="email" type="email" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp" placeholder="Email" value="{{old('email')}}">
                        @if($errors->has('email'))
                        <span class="help-block">{{$errors->first('email')}}</span>
                        @endif
                    </div>

                    <div class="form-group{{$errors->has('jenis_kelamin') ? ' has-error' : ''}}">
                        <label for="exampleFormControlSelect1">Pilih Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" id="exampleFormControlSelect1">
                            <option>Pilih</option>
                            <option value="L"{{(old('jenis_kelamin') == 'L') ? ' selected' : ''}}>Laki-laki</option>
                            <option value="P"{{(old('jenis_kelamin') == 'P') ? ' selected' : ''}}>Perempuan</option>
                            <option value="P"{{(old('jenis_kelamin') == 'P') ? ' selected' : ''}}>Kucing</option>
                        </select>
                        @if($errors->has('jenis_kelamin'))
                        <span class="help-block">{{$errors->first('jenis_kelamin')}}</span>
                        @endif
                    </div>  

                    <div class="form-group{{$errors->has('agama') ? ' has-error' : ''}}">
                        <label for="exampleInputemail1">Agama</label>
                        <input name="agama" type="text" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp" placeholder="agama" value="{{old('agama')}}">
                        @if($errors->has('agama'))
                        <span class="help-block">{{$errors->first('agama')}}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="exampleInputemail1">Alamat</label>
                        <textarea name="alamat" type="text" class="form-control" id="exampleInputemail1" aria-describedby="emailHelp">{{old('alamat')}}</textarea>
                    </div>

                    <div class="form-group{{$errors->has('avatar') ? ' has-error' : ''}}">
                    <label for="exampleInputemail1">Avatar</label>
                    <input type="file" name="avatar" class="form-control" value="{{old('avatar')}}">
                    @if($errors->has('avatar'))
                        <span class="help-block">{{$errors->first('avatar')}}</span>
                        @endif
                </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        @stop