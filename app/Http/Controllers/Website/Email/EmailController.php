<?php
namespace App\Http\Controllers\Website\Email;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class EmailController extends MyBaseController {

	// send Email !
	public function sendEmailContact(Request $request){
		$request  = $request->input();
		try{
			$results = \EmailFacade::sendEmail($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

		//save subscribe
		public function subscribe(Request $request){
			$request  = $request->input();
			try{
				$results = \EmailFacade::subscribe($request);
				if($results==null){
					abort(400);
				}
				return $results;
			}catch(Exception $e){
				abort(500);
			}
		}

}
