<?php
namespace App\Http\Controllers\Website\Payment;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class PaymentController extends MyBaseController {

	// get Data Payment ID !
	public function getDataPaymentID(Request $request){
		$request  = $request->input();
		try{
			$results = \PaymentFacade::getDataPaymentID($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

	// get Update Payment ID !
	public function updatePaymentID(Request $request){
		$request  = $request->input();
		try{
			$results = \PaymentFacade::updatePaymentID($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

	public function genaratePDF(Request $request){
		$request  = $request->input();
		try{
			$results = \PaymentFacade::genaratePDF($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

}
