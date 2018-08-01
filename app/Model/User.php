<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  use SoftDeletes;

  protected $table = 'user';
	public $timestamps = false;
	protected $primaryKey = 'id';
	protected $fillable = ['username','password','email','name','verifyHas','verified','joined','deleted_at'];
}
