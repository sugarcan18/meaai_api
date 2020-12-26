<?php

use App\email_contact_type as email_contact_type;
use Illuminate\Database\Seeder;

class EmailContactTypeSeeder extends Seeder{
	public function run(){
		email_contact_type::truncate();
		email_contact_type::create(["contact_type"=>"Touring Center"]);
		email_contact_type::create(["contact_type"=>"Northern Smile Travel"]);
		email_contact_type::create(["contact_type"=>"Transfer"]);
		email_contact_type::create(["contact_type"=>"All"]);
	}
}
?>