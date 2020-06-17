<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class peminjaman extends model
{
  protected $table = 't_peminjaman';
  protected $primaryKey = 'tpj_id';
  public $remember_token = false;
  public $timestamps = false;
  const UPDATED_AT = 'updated_at';
  const CREATED_AT = 'created_at';

  protected $fillable = [
    'tpj_id'  ,
    'tpj_kode' ,
    'tpj_anggota' ,
    'tpj_staff' ,
    'tpj_date_pinjam' ,
    'tpj_date_kembali' ,
    'tpj_created_by' ,
    'tpj_created_at' ,
    'tpj_date_tempo' ,
  ];

  public function getDateFormat()
  {
    return 'Y-m-d H:i:s';
  }
}