<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccommodationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accommodation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('accommodation_id');
			$table->string('accommodation_name');
			$table->string('accommodation_type_id');
			$table->integer('room');
			$table->integer('room_type_id');
			$table->string('period_start_price');
			$table->string('period_end_price');
			$table->string('address');
			$table->string('phone');
			$table->string('website');
			$table->string('email');
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
		Schema::drop('accommodation');
	}

}
