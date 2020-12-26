<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTravelTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('travel_type');
		Schema::create('travel_type', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('travel_type_id');
			$table->string('travel_type_name');
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
		Schema::drop('travel_type');
	}

}
