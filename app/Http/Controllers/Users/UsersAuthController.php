<?php
namespace App\Http\Controllers\Users;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Redirect;

class UsersAuthController extends Controller {

    public function UserLogin(Request $request){
        $data = $request->input();
        try{
            $results = \UsersAuthFacade::UserLogin($data);
            if($results==null){
                abort(400);
            }
            return $results;
        }catch(Exception $e){
            abort(500);
        }
    }

    public function UserLogOut(Request $request){
        $data = $request->input();
        try{
            $results = \UsersAuthFacade::UserLogOut($data);
            if($results==null){
                abort(400);
            }
            return $results;
        }catch(Exception $e){
            abort(500);
        }
    }

}