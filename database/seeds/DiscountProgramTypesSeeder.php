<?php

use App\discount_program_type as discount_program_type;
use Illuminate\Database\Seeder;

class DiscountProgramTypesSeeder extends Seeder{
	public function run(){
		discount_program_type::truncate();
    discount_program_type::create(["type"=>"tour"]);
    discount_program_type::create(["type"=>"promotion"]);
    discount_program_type::create(["type"=>"package"]);
	}
}
?>