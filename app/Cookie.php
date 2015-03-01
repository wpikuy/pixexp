<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cookie extends Model {

	protected $table = 'pix_cookies';
	protected $fillable = ['name'];

}
