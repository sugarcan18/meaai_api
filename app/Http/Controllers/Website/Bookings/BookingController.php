<?php
namespace App\Http\Controllers\Website\Bookings;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class BookingController extends MyBaseController {

	// get Tours Price RATE!
	public function getTourPriceRate(Request $request){
		$request  = $request->input();
		try{
			$results = \BookingFacade::getTourPriceRate($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

	// save Booking!
	public function saveBooking(Request $request){
		$request  = $request->input();
		try{
			$results = \BookingFacade::saveBooking($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}


}
