<?php

use App\transfer_mode as transfer_mode;
use Illuminate\Database\Seeder;

class TransferModeSeeder extends Seeder{
	public function run(){
		transfer_mode::truncate();
		transfer_mode::create(["mode"=>"One way"]);
		transfer_mode::create(["mode"=>"Round trip"]);
	}
}
?>