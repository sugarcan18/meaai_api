<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelResTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('travel_res', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('travel_res_id');
			$table->string('travel_res_name');
			$table->string('distance');
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
		Schema::drop('travel_res');
	}

}
