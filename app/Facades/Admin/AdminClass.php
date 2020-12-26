<?php
namespace App\Facades\Admin;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
//model
use App\users as users;
use App\Repositories\Admin\AdminRepository as AdminRepo;

class AdminClass
{

    public function __construct(AdminRepo $AdminRepo)
    {
        $this->AdminRepo = $AdminRepo;
    }

    /*  Register logic
            1. Check email repeat
            2. Save accounts table
            3. Save account profile table
    */

    public function getTraveType()
    {
        $this->returnData = new users;

        $travel_type = $this->AdminRepo->getTravelType();
        if ($travel_type === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, not have travel type!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get travel type!';
        $this->returnData->data = $travel_type;
        return $this->returnData;
    }

    public function getSeasonType()
    {
        $this->returnData = new users;

        $season_type = $this->AdminRepo->getSeasonType();
        if ($season_type === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, not have season type!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get season type!';
        $this->returnData->data = $season_type;
        return $this->returnData;
    }

    public function saveTravel($data)
    {
        $this->returnData = new users;

        $travel_id = $this->AdminRepo->saveTravel($data);

        if ($travel_id === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, save travel!';
        $this->returnData->data = $travel_id;
        return $this->returnData;
    }

    public function uploadImages($path, $travel_id, $image_name)
    {
        $this->returnData = new users;

        $upload_images = $this->AdminRepo->uploadImages($path, $travel_id, $image_name);

        if ($upload_images === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save iamges!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, save iamges!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function gettravel()
    {
        $this->returnData = new users;
        $travel_array = [];

        $get_travel = $this->AdminRepo->gettravel();

        $travel_type = $this->AdminRepo->getTravelType();
        $season_type = $this->AdminRepo->getSeasonType();

        foreach ($get_travel as $value) {
            $this->travel_ = new users;
            $this->travel_->id = $value->id;
            $this->travel_->travel_id = $value->travel_id;
            $this->travel_->travel_name = $value->travel_name;
            $this->travel_->travel_detail = $value->travel_detail;
            $this->travel_->travel_type_id = $this->AdminRepo->check_travel_type($value->travel_type_id);
            $this->travel_->season_id = $this->AdminRepo->check_season_type($value->season_id);
            $this->travel_->travel_acc = $this->AdminRepo->travel_acc($value->travel_id);
            $this->travel_->travel_res = $this->AdminRepo->travel_res($value->travel_id);
            $this->travel_->people = $value->people;
            $this->travel_->lat = $value->lat;
            $this->travel_->lng = $value->lng;
            $this->travel_->images = $this->AdminRepo->get_images($value->travel_id);
            $this->travel_->is_active = $value->is_active;
            array_push($travel_array, $this->travel_);
        }

        if ($get_travel === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, get Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get Travel!';
        $this->returnData->data = $travel_array;
        return $this->returnData;
    }

    public function deletetravel($data)
    {
        $this->returnData = new users;

        $delete_travel = $this->AdminRepo->deletetravel($data);

        if ($delete_travel === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Delete Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Delete Travel!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function updatetravel($data)
    {
        $this->returnData = new users;

        $update_travel = $this->AdminRepo->updatetravel($data);

        if ($update_travel === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update Travel!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function updateTravelAcc($data){
        $this->returnData = new users;
        $data_ = array_get($data , 'travel_acc');

        $this->AdminRepo->setTravelAcc_nonActive(array_get($data_[0] , 'travel_id'));

        foreach($data_ as $value){
                $update = $this->AdminRepo->updateTravelAcc($value);
        }

        if ($update === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Travel Acc!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update Travel Acc!';
        $this->returnData->data = '';
        return $this->returnData;

    }

    public function updateTravelRes($data){
        $this->returnData = new users;
        $data_ = array_get($data , 'travel_res');

        $this->AdminRepo->setTravelRes_nonActive(array_get($data_[0] , 'travel_id'));

        foreach($data_ as $value){
            $update = $this->AdminRepo->updateTravelRes($value);
        }

        if ($update === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Travel Res!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update Travel! Res';
        $this->returnData->data = '';
        return $this->returnData;

    }


    // --------------------------------------------------------  Acc  ------------------------------------------------------------

    public function getAccType()
    {
        $this->returnData = new users;

        $acc_type = $this->AdminRepo->getAccType();
        if ($acc_type === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, not have Acc type!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get Acc type!';
        $this->returnData->data = $acc_type;
        return $this->returnData;
    }

    public function getRoomType()
    {
        $this->returnData = new users;

        $room_type = $this->AdminRepo->getRoomType();
        if ($room_type === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, not have Room type!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get Room type!';
        $this->returnData->data = $room_type;
        return $this->returnData;
    }

    public function saveAcc($data){
        $this->returnData = new users;

        $saveAcc = $this->AdminRepo->saveAcc($data);
        if ($saveAcc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save Data!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, save Data!';
        $this->returnData->data = $saveAcc;
        return $this->returnData;
    }

    public function getAcc(){
        $this->returnData = new users;

        $acc_array = [];

        $getAcc = $this->AdminRepo->getAcc();

        $acc_type = $this->AdminRepo->getAccType();
        $room_type = $this->AdminRepo->getSeasonType();

        foreach ($getAcc as $value) {
            $this->acc_ = new users;
            $this->acc_->id = $value->id;
            $this->acc_->accommodation_id = $value->accommodation_id;
            $this->acc_->accommodation_name = $value->accommodation_name;
            $this->acc_->description = $value->description;
            $this->acc_->accommodation_type = $this->AdminRepo->check_acc_type($value->accommodation_type_id);
            $this->acc_->room_type = $this->AdminRepo->check_room_type($value->room_type_id);
            $this->acc_->room = $value->room;
            $this->acc_->images = $this->AdminRepo->images_acc($value->id);
            $this->acc_->period_start_price = $value->period_start_price;
            $this->acc_->period_end_price = $value->period_end_price;
            $this->acc_->address = $value->address;
            $this->acc_->phone = $value->phone;
            $this->acc_->website = $value->website;
            $this->acc_->email = $value->email;
            array_push($acc_array, $this->acc_);
        }

        if ($getAcc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, get Data!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get Data!';
        $this->returnData->data = $acc_array;
        return $this->returnData;
    
    }

    public function deleteAcc($data){
        $this->returnData = new users;

        $delete_acc = $this->AdminRepo->deleteAcc($data);

        if ($delete_acc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Delete Acc!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Delete Acc!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function updateAcc($data){
        $this->returnData = new users;


        $update_travel = $this->AdminRepo->updateAcc($data);

        if ($update_travel === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update Travel!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function uploadImages_acc($path, $acc_id, $image_name)
    {
        $this->returnData = new users;

        $upload_images = $this->AdminRepo->uploadImages_acc($path, $acc_id, $image_name);

        if ($upload_images === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save iamges!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, save iamges!';
        $this->returnData->data = '';
        return $this->returnData;
    }


        // --------------------------------------------------------  Res  ------------------------------------------------------------


    public function getResType(){
        $this->returnData = new users;

        $get_Res = $this->AdminRepo->getResType();

        if ($get_Res === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update Travel!';
        $this->returnData->data = $get_Res;
        return $this->returnData;
    }

    public function saveRes($data){
        $this->returnData = new users;

        $saveRes = $this->AdminRepo->saveRes($data);
        if ($saveRes === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save Data!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, save Data!';
        $this->returnData->data = $saveRes;
        return $this->returnData;
    }

    public function getRes(){
        $this->returnData = new users;

        $res_array = [];

        $getRes = $this->AdminRepo->getRes();


        foreach ($getRes  as $value) {
            $this->res_ = new users;
            $this->res_->id = $value->id;
            $this->res_->restaurant_id = $value->restaurant_id;
            $this->res_->restaurant_name = $value->restaurant_name;
            $this->res_->description = $value->description;
            $this->res_->restaurant_type = $this->AdminRepo->check_ResType($value->restaurant_type_id);
            $this->res_->images = $this->AdminRepo->images_res($value->id);
            $this->res_->time_open = $value->time_open;
            $this->res_->time_close = $value->time_close;
            $this->res_->address = $value->address;
            $this->res_->phone = $value->phone;
            $this->res_->website = $value->website;
            array_push($res_array, $this->res_);
        }

        if ($getRes === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, get Data!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, get Data!';
        $this->returnData->data = $res_array;
        return $this->returnData;
    }

    public function delteRes($data){
        $this->returnData = new users;

        $delete_acc = $this->AdminRepo->deleteRes($data);

        if ($delete_acc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Delete Res!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Delete Res!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function updateRes($data){
        $this->returnData = new users;

        $delete_acc = $this->AdminRepo->updateRes($data);

        if ($delete_acc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Res!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update Res!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function uploadImages_res($path, $res_id, $image_name)
    {
        $this->returnData = new users;

        $upload_images = $this->AdminRepo->uploadImages_res($path, $res_id, $image_name);

        if ($upload_images === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save iamges!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, save iamges!';
        $this->returnData->data = '';
        return $this->returnData;
    }
}
