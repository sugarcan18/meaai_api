<?php
namespace App\Http\Controllers\Website\Update;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class UpdateController extends MyBaseController {

	// Update Information Guest!
	public function updateinformationGuest(Request $request){
		try{
			$results = \UpdateFacade::updateinformationGuest($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

}
