@extends('layouts_backend._main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="card-body">

        <div class="container-fluid">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('assets_backend/dist/img/user2-160x160.jpg') }}" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                    <p class="text-muted text-center">Mahasiswa</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Status</b> <a class="float-right">Aktif</a>
                        </li>
                        <li class="list-group-item">
                            <b>Fakultas</b> <a class="float-right">Teknik Informatika</a>
                        </li>
                        <li class="list-group-item">
                            <b>Alamat</b> <a class="float-right">{{ Auth::user()->address }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Telepon</b> <a class="float-right">{{ Auth::user()->tlp }}</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary btn-block"><b>Edit Data</b></a>
                    <a href="#" class="btn btn-primary btn-block"><b>Print Kartu Anggota</b></a>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
</div>
@endsection