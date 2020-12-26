<?php
namespace App\Facades\Overviews;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
//model
use App\users as users;
use App\Repositories\Overviews\OverviewsRepository as OverviewsRepo;

class OverviewsClass
{
    public function __construct(OverviewsRepo $OverviewsRepo)
    {
        $this->OverviewsRepo = $OverviewsRepo;
    }


    public function getTravel($data)
    {
        $this->returnData = new users;
        $travel_array = [];

        $get_travel = $this->OverviewsRepo->getTravel($data);

        foreach ($get_travel as $value) {
            $this->travel_ = new users;
            $this->travel_->id = $value->id;
            $this->travel_->travel_id = $value->travel_id;
            $this->travel_->travel_name = $value->travel_name;
            $this->travel_->travel_detail = $value->travel_detail;
            $this->travel_->travel_type_id = $this->OverviewsRepo->check_travel_type($value->travel_type_id);
            $this->travel_->season_id = $this->OverviewsRepo->check_season_type($value->season_id);
            $this->travel_->travel_acc = $this->check_travel_acc($value->travel_id);
            $this->travel_->travel_res = $this->check_travel_res($value->travel_id);
            $this->travel_->people = $value->people;
            // $this->travel_->images = $this->OverviewsRepo->travel_images($value->travel_id);
            $this->travel_->lat = $value->lat;
            $this->travel_->lng = $value->lng;
            $this->travel_->images = $this->OverviewsRepo->get_images($value->travel_id);
            $this->travel_->is_active = $value->is_active;
            array_push($travel_array, $this->travel_);
        }

        if ($get_travel === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Get Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Get Travel!';
        $this->returnData->data = $travel_array;
        return $this->returnData;
    }

    public function check_travel_acc($travel_id)
    {
        $acc = $this->OverviewsRepo->check_travel_acc($travel_id);
        if ($acc !== 'false') {
            $acc_ = [];
            foreach ($acc as $value) {
                $this->acc_ = new users;
                $this->acc_->acc_id = $value->acc_id;
                $this->acc_->acc_name = $this->OverviewsRepo->getAcc_($value->acc_id);
                array_push($acc_, $this->acc_);
            }
            return $acc_;
        } else {
            return 'false';
        }
    }


    public function check_travel_res($travel_id)
    {
        $res = $this->OverviewsRepo->check_travel_res($travel_id);
        if ($res !== 'false') {
            $res_ = [];
            foreach ($res as $value) {
                $this->res_ = new users;
                $this->res_->res_id = $value->res_id;
                $this->res_->res_name = $this->OverviewsRepo->getRes_($value->res_id);
                array_push($res_, $this->res_);
            }
            return $res_;
        } else {
            return 'false';
        }
    }

    public function getAcc($data)
    {
        $this->returnData = new users;
        $acc_array = [];

        $get_acc = $this->OverviewsRepo->getAcc($data);

        foreach ($get_acc as $value) {
            $this->acc_ = new users;
            $this->acc_->id = $value->id;
            $this->acc_->acc_id = $value->accommodation_id;
            $this->acc_->acc_name = $value->accommodation_name;
            $this->acc_->acc_detail = $value->description;
            $this->acc_->acc_type = $this->OverviewsRepo->get_acc_type($value->accommodation_type_id);
            $this->acc_->room = $value->room;
            $this->acc_->room_type = $this->OverviewsRepo->get_room_type($value->room_type_id);
            $this->acc_->period_start_price = $value->period_start_price;
            $this->acc_->period_end_price = $value->period_end_price;
            $this->acc_->images = $this->OverviewsRepo->get_images_acc($value->id);
            $this->acc_->address = $value->address;
            $this->acc_->phone = $value->phone;
            $this->acc_->website = $value->website;
            $this->acc_->email = $value->email;
            $this->acc_->is_active = $value->is_active;
            array_push($acc_array, $this->acc_);
        }

        if ($get_acc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Get Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Get Travel!';
        $this->returnData->data = $acc_array;
        return $this->returnData;
    }

    public function getRes($data)
    {
        $this->returnData = new users;
        $res_array = [];

        $get_res = $this->OverviewsRepo->getRes($data);

        foreach ($get_res as $value) {
            $this->res_ = new users;
            $this->res_->id = $value->id;
            $this->res_->res_id = $value->restaurant_id;
            $this->res_->res_name = $value->restaurant_name;
            $this->res_->res_detail = $value->description;
            $this->res_->res_type = $this->OverviewsRepo->get_res_type($value->restaurant_type_id);
            $this->res_->time_open = $value->time_open;
            $this->res_->time_close = $value->time_close;
            $this->res_->address = $value->address;
            $this->res_->phone = $value->phone;
            $this->res_->website = $value->website;
            $this->res_->images = $this->OverviewsRepo->get_images_res($value->id);
            $this->res_->is_active = $value->is_active;
            array_push($res_array, $this->res_);
        }

        if ($get_res === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Get Travel!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Get Travel!';
        $this->returnData->data = $res_array;
        return $this->returnData;
    }
}
