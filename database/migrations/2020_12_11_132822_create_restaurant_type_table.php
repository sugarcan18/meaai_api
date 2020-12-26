<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resrestaurant_type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('resrestaurant_type_id');
			$table->string('resrestaurant_type_name');
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
		Schema::drop('resrestaurant_type');
	}

}
