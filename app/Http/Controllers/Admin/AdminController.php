<?php
namespace App\Http\Controllers\Admin;

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

class AdminController extends Controller
{

    // ----------------------------------------------------------------- TRAVEL -------------------------------------------------------------------
    public function getTraveType()
    {
        try {
            $results = \AdminFacade::getTraveType();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getSeasonType()
    {
        try {
            $results = \AdminFacade::getSeasonType();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveTravel(Request $request)
    {
        $data = $request->input();
        try {
            $results = \AdminFacade::saveTravel($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function uploadImages(Request $request)
    {
        $file = $request->file('photo');
        $imgCode = uniqid();
        $originalImage = $file->getClientOriginalName();
        $originalImage = $imgCode . '-' . $originalImage;
        $travel_id = $request->input('value_id');
        $file->move(public_path('images' . '/' . $travel_id), $originalImage);
        $photoURL = url('images' . '/' . $travel_id . '/' . $originalImage);
        try {
            $results = \AdminFacade::uploadImages($photoURL, $travel_id, $originalImage);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function gettravel()
    {
        try {
            $results = \AdminFacade::gettravel();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function deletetravel(Request $request)
    {
        $data = $request->input();
        try {
            $results = \AdminFacade::deletetravel($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updatetravel(Request $request)
    {
        $data = $request->input();
        try {
            $results = \AdminFacade::updatetravel($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateTravelAcc(Request $request)
    {
        $data = $request->input();
        try {
            $results = \AdminFacade::updateTravelAcc($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateTravelRes(Request $request)
    {
        $data = $request->input();
        try {
            $results = \AdminFacade::updateTravelRes($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    // ----------------------------------------------------------------- ACC -------------------------------------------------------------------

    public function getAccType()
    {
        try {
            $results = \AdminFacade::getAccType();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getRoomType()
    {
        try {
            $results = \AdminFacade::getRoomType();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveAcc(Request $request){
        $data = $request->input();
        try {
            $results = \AdminFacade::saveAcc($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAcc(){
        try {
            $results = \AdminFacade::getAcc();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function deleteAcc(Request $request){
        $data = $request->input();
        try {
            $results = \AdminFacade::deleteAcc($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateAcc(Request $request){
        $data = $request->input();
        try {
            $results = \AdminFacade::updateAcc($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function uploadImageAcc(Request $request)
    {
        $file = $request->file('photo');
        $imgCode = uniqid();
        $originalImage = $file->getClientOriginalName();
        $originalImage = $imgCode . '-' . $originalImage;
        $acc_id = $request->input('value_id');
        $file->move(public_path('images_acc' . '/' . $acc_id), $originalImage);
        $photoURL = url('images_acc' . '/' . $acc_id . '/' . $originalImage);
        try {
            $results = \AdminFacade::uploadImages_acc($photoURL, $acc_id, $originalImage);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

        // ----------------------------------------------------------------- RES -------------------------------------------------------------------

    public function getResType(){
        try {
            $results = \AdminFacade::getResType();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveRes(Request $request){
        $data = $request->input();
        try {
            $results = \AdminFacade::saveRes($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getRes(){
        try {
            $results = \AdminFacade::getRes();
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function delteRes(Request $request){
        $data = $request->input();
        try {
            $results = \AdminFacade::delteRes($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateRes(Request $request){
        $data = $request->input();
        try {
            $results = \AdminFacade::updateRes($data);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function uploadImages_res(Request $request)
    {
        $file = $request->file('photo');
        $imgCode = uniqid();
        $originalImage = $file->getClientOriginalName();
        $originalImage = $imgCode . '-' . $originalImage;
        $res_id = $request->input('value_id');
        $file->move(public_path('images_res' . '/' . $res_id), $originalImage);
        $photoURL = url('images_res' . '/' . $res_id . '/' . $originalImage);
        try {
            $results = \AdminFacade::uploadImages_res($photoURL, $res_id, $originalImage);
            if ($results == null) {
                abort(400);
            }
            return $results;
        } catch (Exception $e) {
            abort(500);
        }
    }

    // public function getacc(){
    //     try {
    //         $results = \UsersFacade::getacc();
    //         if ($results == null) {
    //             abort(400);
    //         }
    //         return $results;
    //     } catch (Exception $e) {
    //         abort(500);
    //   }
    // }

    // public function getres(){
    //     try {
    //         $results = \UsersFacade::getres();
    //         if ($results == null) {
    //             abort(400);
    //         }
    //         return $results;
    //     } catch (Exception $e) {
    //         abort(500);
    //   }
    // }
}
