<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResetPasswordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('reset_code');
		Schema::create('reset_code', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('email');
			$table->string('reset_code');
			$table->tinyInteger('is_active')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reset_code');
	}

}
