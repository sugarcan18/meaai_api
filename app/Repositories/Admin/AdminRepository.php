<?php 
namespace App\Repositories\Admin;

use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

use Illuminate\Support\Str;

//model
use App\users as Users;
use App\history_login as History_login;
use App\reset_code as ResetCode;
use App\travel as Travel;
use App\travel_images as Travel_images;
use App\accommodation as Accommodation;
use App\restaurant as Restaurant;
use App\acc_images as Acc_Images;
use App\res_images as Res_Images;
use App\travel_acc as Travel_Acc;
use App\travel_res as Travel_Res;


class AdminRepository
{

    public function __construct(
        Users $Users,
        ResetCode $ResetCode,
        History_login $History_login,
        Travel $Travel,
        Travel_images $Travel_images,
        Accommodation $Accommodation,
        Restaurant $Restaurant,
        Acc_Images $Acc_Images,
        Res_Images $Res_Images,
        Travel_Acc $Travel_Acc,
        Travel_Res $Travel_Res
    ) {
        $this->Users = $Users;
        $this->ResetCode = $ResetCode;
        $this->History_login = $History_login;
        $this->Travel = $Travel;
        $this->Travel_images = $Travel_images;
        $this->Accommodation = $Accommodation;
        $this->Restaurant = $Restaurant;
        $this->Acc_Images = $Acc_Images;
        $this->Res_Images = $Res_Images;
        $this->Travel_Acc = $Travel_Acc;
        $this->Travel_Res = $Travel_Res;
    }


    // --------------------------------------------------------------------------- TRAVEL --------------------------------------------------------------------

    public function getTravelType()
    {
        $result = \DB::table('travel_type')
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function check_travel_type($id)
    {
        $result = \DB::table('travel_type')
            ->where('travel_type_id', $id)
            ->get(['travel_type_id', 'travel_type_name']);
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getSeasonType()
    {
        $result = \DB::table('season_type')
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function check_season_type($id)
    {
        $result = \DB::table('season_type')
            ->where('season_type_id', $id)
            ->get(['season_type_id', 'season_type_name']);
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function saveTravel($data)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $travel = [
            'travel_id' =>  rand(1, 1000000),
            'travel_name' => array_get($data, 'name'),
            'travel_detail' => array_get($data, 'description'),
            'travel_type_id' => array_get($data, 'type'),
            'season_id' => array_get($data, 'season'),
            'people' => array_get($data, 'people'),
            'lat' => array_get($data, 'lat'),
            'lng' => array_get($data, 'lng'),
            'is_active' => '1'
        ];

        $result = $this->Travel->insertGetId($travel);

        if ($result) {
            return array_get($travel, 'travel_id');
        } else {
            return 'false';
        }
    }

    public function uploadImages($path, $travel_id, $image_name)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $images = [
            'travel_id' =>  $travel_id,
            'path' => $path,
            'images' => $image_name,
            'is_active' => '1'
        ];

        $result = $this->Travel_images->insertGetId($images);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function gettravel()
    {
        $result = \DB::table('travel')
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function deletetravel($data)
    {
        $update = [
            'is_active' => 0
        ];

        $result = $this->Travel->where('travel_id', array_get($data, 'travel_id'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function get_images($travel_id)
    {
        $result = \DB::table('travel_images')
            ->where('travel_id', $travel_id)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function updatetravel($data)
    {
        $update = [
            'travel_name' => array_get($data, 'name'),
            'travel_detail' => array_get($data, 'description'),
            'travel_type_id' => array_get($data, 'type'),
            'season_id' => array_get($data, 'season'),
            'people' => array_get($data, 'people'),
            'lat' => array_get($data, 'lat'),
            'lng' => array_get($data, 'lng'),
        ];

        $result = $this->Travel->where('id', array_get($data, 'id'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updateTravelAcc($data){
        $travel_acc = [
            'travel_id' => array_get($data, 'travel_id'),
            'acc_id' => array_get($data, 'id'),
            'is_active' => array_get($data, 'status')?1:0
        ];

        $result = $this->Travel_Acc->insertGetId($travel_acc);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
        
    }

    public function setTravelAcc_nonActive($travel_id){
        $update = [
            'is_active' => 0,
        ];

        $result = $this->Travel_Acc->where('travel_id', $travel_id)->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updateTravelRes($data){
        $travel_res = [
            'travel_id' => array_get($data, 'travel_id'),
            'res_id' => array_get($data, 'id'),
            'is_active' => array_get($data, 'status')?1:0
        ];

        $result = $this->Travel_Res->insertGetId($travel_res);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
        
    }

    public function setTravelRes_nonActive($travel_id){
        $update = [
            'is_active' => 0,
        ];

        $result = $this->Travel_Res->where('travel_id', $travel_id)->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }


    // --------------------------------------------------------------------------- ACC --------------------------------------------------------------------

    public function getAccType()
    {
        $result = \DB::table('accommodation_type')
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getRoomType()
    {
        $result = \DB::table('room_type')
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function saveAcc($data)
    {
        $acc = [
            'accommodation_id' =>  rand(1, 1000000),
            'accommodation_name' => array_get($data, 'accommodation_name'),
            'description' => array_get($data, 'description'),
            'accommodation_type_id' => array_get($data, 'accommodation_type'),
            'room' => array_get($data, 'room'),
            'room_type_id' => array_get($data, 'room_type'),
            'period_start_price' => array_get($data, 'period_start_price'),
            'period_end_price' => array_get($data, 'period_end_price'),
            'address' => array_get($data, 'address'),
            'phone' => array_get($data, 'phone'),
            'website' => array_get($data, 'website'),
            'email' => array_get($data, 'email'),
            'is_active' => '1'
        ];

        $result = $this->Accommodation->insertGetId($acc);

        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getAcc()
    {
        $result = \DB::table('accommodation')
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function travel_images($travel_id){
        $result = \DB::table('travel_images')
            ->where('travel_id', $travel_id)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function check_acc_type($id)
    {
        $result = \DB::table('accommodation_type')
            ->where('accommodation_type_id', $id)
            ->get(['accommodation_type_id', 'accommodation_type_name']);
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function check_room_type($id)
    {
        $result = \DB::table('room_type')
            ->where('room_type_id', $id)
            ->get(['room_type_id', 'room_type_name']);
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function deleteAcc($data)
    {
        $update = [
            'is_active' => 0
        ];

        $result = $this->Accommodation->where('accommodation_id', array_get($data, 'accommodation_id'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updateAcc($data)
    {
        $update = [
            'accommodation_name' => array_get($data, 'accommodation_name'),
            'description' => array_get($data, 'description'),
            'accommodation_type_id' => array_get($data, 'accommodation_type'),
            'room_type_id' => array_get($data, 'room_type'),
            'room' => array_get($data, 'room'),
            'period_end_price' => array_get($data, 'period_end_price'),
            'period_start_price' => array_get($data, 'period_start_price'),
            'address' => array_get($data, 'address'),
            'phone' => array_get($data, 'phone'),
            'email' => array_get($data, 'email'),
            'website' => array_get($data, 'website')
        ];

        $result = $this->Accommodation->where('accommodation_id', array_get($data, 'accommodation_id'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function uploadImages_acc($path, $acc_id, $image_name)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $images = [
            'acc_id' =>  $acc_id,
            'path' => $path,
            'images' => $image_name,
            'is_active' => '1'
        ];

        $result = $this->Acc_Images->insertGetId($images);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function images_acc($acc_id){
        $result = \DB::table('acc_images')
            ->where('acc_id' , $acc_id)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function travel_acc($travel_id){
        $result = \DB::table('travel_acc')
            ->where('travel_id' , $travel_id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }        
    }

    public function travel_res($travel_id){
        $result = \DB::table('travel_res')
            ->where('travel_id' , $travel_id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }        
    }
    


    // --------------------------------------------------------------------------- Res --------------------------------------------------------------------

    public function getResType()
    {
        $result = \DB::table('restaurant_type')
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function saveRes($data)
    {
        $acc = [
            'restaurant_id' =>  rand(1, 1000000),
            'restaurant_name' => array_get($data, 'name'),
            'description' => array_get($data, 'description'),
            'restaurant_type_id' => array_get($data, 'type'),
            'time_open' => array_get($data, 'time_open'),
            'time_close' => array_get($data, 'time_close'),
            'address' => array_get($data, 'address'),
            'phone' => array_get($data, 'phone'),
            'website' => array_get($data, 'website'),
            'is_active' => '1'
        ];

        $result = $this->Restaurant->insertGetId($acc);

        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getRes()
    {
        $result = \DB::table('restaurant')
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function check_ResType($id)
    {
        $result = \DB::table('restaurant_type')
            ->where('restaurant_type_id', $id)
            ->get(['restaurant_type_id', 'restaurant_type_name']);
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function deleteRes($data){
        $update = [
            'is_active' => 0
        ];

        $result = $this->Restaurant->where('restaurant_id', array_get($data, 'restaurant_id'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updateRes($data){
        $update = [
            'restaurant_name' => array_get($data, 'name'),
            'description' => array_get($data, 'description'),
            'restaurant_type_id' => array_get($data, 'type'),
            'time_open' => array_get($data, 'time_open'),
            'time_close' => array_get($data, 'time_close'),
            'address' => array_get($data, 'address'),
            'phone' => array_get($data, 'phone'),
            'website' => array_get($data, 'website')
        ];

        $result = $this->Restaurant->where('restaurant_id', array_get($data, 'id'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function uploadImages_res($path, $res_id, $image_name)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $images = [
            'res_id' =>  $res_id,
            'path' => $path,
            'images' => $image_name,
            'is_active' => '1'
        ];

        $result = $this->Res_Images->insertGetId($images);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function images_res($res_id){
        $result = \DB::table('res_images')
            ->where('res_id' , $res_id)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }
}
