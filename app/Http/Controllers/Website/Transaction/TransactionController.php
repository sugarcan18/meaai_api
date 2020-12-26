<?php
namespace App\Http\Controllers\Website\Transaction;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class TransactionController extends MyBaseController {

	// get Data Transaction ID!
	public function getDataTransactionID(Request $request){
		$request  = $request->input();
		try{
			$results = \TransactionFacade::getDataTransactionID($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

	public function getReceiptPDFID(Request $request){
		$request  = $request->input();
		try{
			$results = \TransactionFacade::getReceiptPDFID($request);
			if($results==null){
				abort(400);
			}
			return $results;
		}catch(Exception $e){
			abort(500);
		}
	}

}
