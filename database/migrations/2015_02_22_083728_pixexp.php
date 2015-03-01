<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Pixexp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pix_pass', function (Blueprint $table){
			$table->increments('id');
			$table->string('password');
		});
		Schema::create('pix_req', function (Blueprint $table){
			$table->increments('id');
			$table->string('pid');
			$table->string('time');
			$table->string('state');
		});
		Schema::create('pix_pic', function (Blueprint $table){
			$table->increments('id');
			$table->string('completeTime');
			$table->string('fileName');
			$table->string('pid');
			$table->string('title');
			$table->string('author');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pix_pass');
		Schema::drop('pix_req');
		Schema::drop('pix_pic');
	}

}
