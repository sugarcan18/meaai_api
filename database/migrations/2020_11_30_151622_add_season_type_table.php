<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeasonTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('season_type');
		Schema::create('season_type', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('season_type_id');
			$table->string('season_type_name');
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
		Schema::drop('season_type');
	}

}
