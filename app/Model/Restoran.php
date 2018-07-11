<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restoran extends Model
{
  use SoftDeletes;

  protected $table = 'restoran';
	public $timestamps = false;
	protected $primaryKey = 'id_restoran';
	protected $fillable = ['nama_restoran','detail_restoran','latitude','longitude','jam_buka','jam_tutup','hari_buka','id_owner'];
}
