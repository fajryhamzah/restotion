<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RestoranImage extends Model
{
  protected $table = 'restoimage';
	public $timestamps = false;
	protected $primaryKey = 'id_image';
	protected $fillable = ['link','id_restoran'];
}
