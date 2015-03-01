<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class Cookie extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cookie', function (Blueprint $table){
			$table->increments('id');
			$table->string('name');
			$table->string('value');
			$table->string('expires');
			$table->string('max-age');
			$table->string('path');
			$table->string('domain');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cookie');
	}

}
