<?php
namespace App\Http\Controllers\Website\Affiliate;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class AffiliateController extends MyBaseController {

	// get Tours Price RATE!
	public function checkAffiliateID(Request $request){
		$request  = $request->input();
		try{
			$results = \AffiliateFacade::checkAffiliateID($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

}
