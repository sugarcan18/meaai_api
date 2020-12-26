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
use App\Commons\ResponseCode;
use App\Commons\ResponseStatus;
use App\Http\Controllers\MyBaseController;

class UsersController extends Controller
{

    public function UserRegister(Request $request)
    {
        $data = $request->input();        
        try {
            $results = \UsersFacade::UserRegister($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function UserResetPass(Request $request){
        $data = $request->input();        
        try {
            $results = \UsersFacade::UserResetPass($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function UserUpdatePass(Request $request){
        $data = $request->input();        
        try {
            $results = \UsersFacade::UserUpdatePass($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function UserLogin(Request $request){
        $data = $request->input();        
        try {
            $results = \UsersFacade::UserLogin($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function UserLogOut(Request $request){
        $data = $request->input();        
        try {
            $results = \UsersFacade::UserLogOut($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function get_nationality(){
        try {
            $results = \UsersFacade::get_nationality();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function get_users(Request $request){
        $data = $request->input();        

        try {
            $results = \UsersFacade::get_users($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
      }
    }

    public function update_profile(Request $request){
        $data = $request->input();        

        try {
            $results = \UsersFacade::update_profile($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
      }
    }

}

