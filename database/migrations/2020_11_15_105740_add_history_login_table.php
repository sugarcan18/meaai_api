<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHistoryLoginTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('history_login');
		Schema::create('history_login', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('email');
			$table->dateTime('login_datetime');
			$table->dateTime('logout_datetime')->nullable();
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
		Schema::drop('history_login');
	}

}
