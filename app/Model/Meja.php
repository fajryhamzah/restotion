<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
  protected $table = 'meja';
	public $timestamps = false;
	protected $primaryKey = 'id_meja';
	protected $fillable = ['nama_meja','kapasitas','keterangan','status','id_restoran'];
}
