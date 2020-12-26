<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resrestaurant', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('resrestaurant_id');
			$table->string('resrestaurant_name');
			$table->string('description');
			$table->integer('resrestaurant_type_id');
			$table->string('time_open');
			$table->string('time_close');
			$table->string('address');
			$table->string('phone');
			$table->string('website');
			$table->tinyInteger('is_active')->default(1);
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
		Schema::drop('resrestaurant');
	}

}
