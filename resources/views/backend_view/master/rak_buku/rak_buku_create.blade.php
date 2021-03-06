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
            <li class="breadcrumb-item active">Create Rak Buku</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- FORM -->
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Create Rak Buku</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="display: block;">
          <form class="form-save">
            <div class="form-group">
              <label>Alphabet Kode Rak</label>
              <input type="text" class="form-control rak_alphabet" name="rak_alphabet" style="text-transform:uppercase"
                onkeyup="kodes()" maxlength="2">
            </div>
            <div class="form-group">
              <label>Kode</label>
              <input type="text" class="form-control kode" name="kode" readonly="">
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
              <label>Lokasi</label>
              <input type="text" class="form-control" name="lokasi">
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
      url:'{{ route('rak_buku_save') }}',
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
            location.href = '{{ route('rak_buku_index') }}';
             })
        }
      }
    });
  }
  function kodes(argument) {      
    var alphabet = $('.rak_alphabet').val();
    $.ajax({
      url:'{{ route('rak_buku_get_kode') }}',
      data:{alphabet:alphabet},
      type:'get',      
      success:function(data){
        $('.kode').val(data);
      }
    });
  }
</script>