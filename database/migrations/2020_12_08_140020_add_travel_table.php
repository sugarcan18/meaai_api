<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTravelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('travel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('travel_id');
			$table->string('travel_name');
			$table->string('travel_detail');
			$table->string('travel_type_id');
			$table->string('season_id');
			$table->string('lat');
			$table->string('lng');
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
		Schema::drop('travel');
	}

}
