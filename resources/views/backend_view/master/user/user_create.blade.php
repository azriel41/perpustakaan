@extends('layouts_backend._main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active">Create User</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Alert!</h5>
        Pastikan Password Memiliki Panjang Minimal 8
      </div>
      <!-- FORM -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Create User</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="display: block;">
          <form class="form-save">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
              <label>Previleges</label>
              <select name="previleges" class="form-control">
                @foreach ($previlege as $previleges )
                <option value="{{ $previleges->mp_id }}">{{ $previleges->mp_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type="text" class="form-control" name="address">
            </div>
            <div class="form-group">
              <label>Telepon</label>
              <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(+62) 999-9999-9999&quot;"
                name="tlp">
            </div>
            <div class="form-group">
              <label>NBI</label>
              <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;9999999999&quot;"
                name="reg">
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" name="username">
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="button" class="btn btn-primary" onclick="save()"><i class="fas fa-save"></i> Save</button>
        </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </section>
</div>
@endsection

<script type="text/javascript">
  function save(argument) {      
    $.ajax({
      url:'{{ route('previleges_save') }}',
      data:$('.form-save').serialize(),
      type:'get',
      error:function(data){
        if(data.status == 422){
            Swal.fire({
              title: 'Pastikan Data Tidak Kosong.',
              icon: 'error',
              confirmButtonText: 'Ok'
            })
          }
        }, 
      success:function(data){
        if (data.status == 'sukses') {
          Swal.fire({
            title: 'Data Sudah Disimpan.',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(function(result){
            location.href = '{{ route('previleges_index') }}';
             })
        }
      }
    });
  }
</script>