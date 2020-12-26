<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plan', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('plan_id');
			$table->string('travel_id');
			$table->string('travel_type_id');
			$table->string('pax_rate');
			$table->string('pax_rate');
			$table->string('cost');
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
		Schema::drop('plan');
	}

}
