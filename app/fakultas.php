<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fakultas extends model
{
  protected $table = 'm_fakultas';
  protected $primaryKey = 'mf_id';
  public $remember_token = false;
  public $timestamps = false;
  const UPDATED_AT = 'updated_at';
  const CREATED_AT = 'created_at';

  protected $fillable = [
    'mf_id',
    'mf_kode',
    'mf_name',
  ];
  public function user()
  {
    return $this->hasMany('App\User', 'fakultas', 'mf_id');
  }
  public function getDateFormat()
  {
    return 'Y-m-d H:i:s';
  }
  public function jurusanuser()
  {
    return $this->belongsTo('App\jurusan', 'mj_fakultas', 'mf_id');
  }
}
