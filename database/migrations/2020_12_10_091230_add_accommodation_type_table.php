<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccommodationTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accommodation_type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('accommodation_type_id');
			$table->string('accommodation_type_name');
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
		Schema::drop('accommodation_type', function(Blueprint $table)
		{
			//
		});
	}

}
