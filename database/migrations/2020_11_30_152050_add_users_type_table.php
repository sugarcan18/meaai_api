<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('users_type');
		Schema::create('users_type', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('user_type_id');
			$table->string('user_type_name');
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
		Schema::drop('users_type');
	}

}
