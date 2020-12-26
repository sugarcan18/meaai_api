<?php

use App\tour_driver_fee_rate as TourDriverFeeRate;
use Illuminate\Database\Seeder;

class TourDriverFeeRateSeeder extends Seeder{
	public function run(){
		TourDriverFeeRate::truncate();
		TourDriverFeeRate::create(["tour_id"=>"1","tour_pax_id"=>"1","cost"=>"200","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"1","tour_pax_id"=>"2","cost"=>"250","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"1","tour_pax_id"=>"3","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"1","tour_pax_id"=>"4","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"1","tour_pax_id"=>"4","cost"=>"1000","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"2","tour_pax_id"=>"1","cost"=>"200","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"2","tour_pax_id"=>"2","cost"=>"250","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"2","tour_pax_id"=>"3","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"2","tour_pax_id"=>"4","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"2","tour_pax_id"=>"4","cost"=>"600","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"3","tour_pax_id"=>"1","cost"=>"200","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"3","tour_pax_id"=>"2","cost"=>"250","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"3","tour_pax_id"=>"3","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"3","tour_pax_id"=>"4","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"3","tour_pax_id"=>"4","cost"=>"800","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"4","tour_pax_id"=>"1","cost"=>"200","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"4","tour_pax_id"=>"2","cost"=>"250","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"4","tour_pax_id"=>"3","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"4","tour_pax_id"=>"4","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"4","tour_pax_id"=>"4","cost"=>"500","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"5","tour_pax_id"=>"1","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"5","tour_pax_id"=>"2","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"5","tour_pax_id"=>"3","cost"=>"450","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"5","tour_pax_id"=>"4","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"5","tour_pax_id"=>"4","cost"=>"800","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"6","tour_pax_id"=>"1","cost"=>"250","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"6","tour_pax_id"=>"2","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"6","tour_pax_id"=>"3","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"6","tour_pax_id"=>"4","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"6","tour_pax_id"=>"4","cost"=>"800","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"7","tour_pax_id"=>"1","cost"=>"250","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"7","tour_pax_id"=>"2","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"7","tour_pax_id"=>"3","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"7","tour_pax_id"=>"4","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"7","tour_pax_id"=>"4","cost"=>"350","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"8","tour_pax_id"=>"1","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"8","tour_pax_id"=>"2","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"8","tour_pax_id"=>"3","cost"=>"450","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"8","tour_pax_id"=>"4","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"8","tour_pax_id"=>"4","cost"=>"1600","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"9","tour_pax_id"=>"1","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"9","tour_pax_id"=>"2","cost"=>"600","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"9","tour_pax_id"=>"3","cost"=>"700","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"9","tour_pax_id"=>"4","cost"=>"700","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"9","tour_pax_id"=>"4","cost"=>"3300","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"10","tour_pax_id"=>"1","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"10","tour_pax_id"=>"2","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"10","tour_pax_id"=>"3","cost"=>"600","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"10","tour_pax_id"=>"4","cost"=>"600","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"10","tour_pax_id"=>"4","cost"=>"2500","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"11","tour_pax_id"=>"1","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"11","tour_pax_id"=>"2","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"11","tour_pax_id"=>"3","cost"=>"450","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"11","tour_pax_id"=>"4","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"11","tour_pax_id"=>"4","cost"=>"1500","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"12","tour_pax_id"=>"1","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"12","tour_pax_id"=>"2","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"12","tour_pax_id"=>"3","cost"=>"450","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"12","tour_pax_id"=>"4","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"12","tour_pax_id"=>"4","cost"=>"2300","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"13","tour_pax_id"=>"1","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"13","tour_pax_id"=>"2","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"13","tour_pax_id"=>"3","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"13","tour_pax_id"=>"4","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"13","tour_pax_id"=>"4","cost"=>"1200","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"14","tour_pax_id"=>"1","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"14","tour_pax_id"=>"2","cost"=>"500","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"14","tour_pax_id"=>"3","cost"=>"600","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"14","tour_pax_id"=>"4","cost"=>"600","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"14","tour_pax_id"=>"4","cost"=>"2500","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"15","tour_pax_id"=>"1","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"15","tour_pax_id"=>"2","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"15","tour_pax_id"=>"3","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"15","tour_pax_id"=>"4","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"15","tour_pax_id"=>"4","cost"=>"1000","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"16","tour_pax_id"=>"1","cost"=>"300","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"16","tour_pax_id"=>"2","cost"=>"350","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"16","tour_pax_id"=>"3","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"16","tour_pax_id"=>"4","cost"=>"400","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"16","tour_pax_id"=>"4","cost"=>"1000","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"17","tour_pax_id"=>"1","cost"=>"0","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"17","tour_pax_id"=>"2","cost"=>"0","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"17","tour_pax_id"=>"3","cost"=>"0","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"0"]);
		TourDriverFeeRate::create(["tour_id"=>"17","tour_pax_id"=>"4","cost"=>"0","is_staff"=>"1","is_energy"=>"0","is_famtrip"=>"1"]);
		TourDriverFeeRate::create(["tour_id"=>"17","tour_pax_id"=>"4","cost"=>"1800","is_staff"=>"0","is_energy"=>"0","is_famtrip"=>"0"]);
	}
}
?>