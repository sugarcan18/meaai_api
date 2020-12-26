<?php
namespace App\Http\Controllers\Overviews;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Redirect;

class OverviewsController extends Controller {

    public function getTravel(Request $request){
        $data = $request->input();
        try{
            $results = \OverviewsFacade::getTravel($data);
            if($results==null){
                abort(400);
            }
            return $results;
        }catch(Exception $e){
            abort(500);
        }
    }
    
    public function getAcc(Request $request){
        $data = $request->input();
        try{
            $results = \OverviewsFacade::getAcc($data);
            if($results==null){
                abort(400);
            }
            return $results;
        }catch(Exception $e){
            abort(500);
        }
    }

    public function getRes(Request $request){
        $data = $request->input();
        try{
            $results = \OverviewsFacade::getRes($data);
            if($results==null){
                abort(400);
            }
            return $results;
        }catch(Exception $e){
            abort(500);
        }
    }

}