<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCookiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pix_cookies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('value');
			$table->string('expires');
			$table->string('max-age');
			$table->string('path');
			$table->string('domain');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pix_cookies');
	}

}
