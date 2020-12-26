<?php 
namespace App\Repositories\Overviews;

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

class OverviewsRepository
{

    public function __construct(
        Users $Users,
        ResetCode $ResetCode,
        History_login $History_login,
        Travel $Travel,
        Travel_images $Travel_images,
        Accommodation $Accommodation,
        Restaurant $Restaurant
    ) {
        $this->Users = $Users;
        $this->ResetCode = $ResetCode;
        $this->History_login = $History_login;
        $this->Travel = $Travel;
        $this->Travel_images = $Travel_images;
        $this->Accommodation = $Accommodation;
        $this->Restaurant = $Restaurant;
    }

    public function getTravel($data)
    {
        $result = \DB::table('travel')
            ->where('travel_id', array_get($data, 'travel_id'))
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

    public function travel_images($travel_id)
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

    public function check_travel_acc($travel_id)
    {
        $result = \DB::table('travel_acc')
            ->where('travel_id', $travel_id)
            ->where('is_active', 1)
            ->get();

        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getAcc_($id)
    {
        $result = \DB::table('accommodation')
            ->where('accommodation_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getRes_($id)
    {
        $result = \DB::table('restaurant')
            ->where('restaurant_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function check_travel_res($travel_id)
    {
        $result = \DB::table('travel_res')
            ->where('travel_id', $travel_id)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    // ------------------------------------------------------------------ Acc ----------------------------------------------------------------
    public function getAcc($data)
    {
        $result = \DB::table('accommodation')
            ->where('accommodation_id', array_get($data, 'acc_id'))
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function get_acc_type($id)
    {
        $result = \DB::table('accommodation_type')
            ->where('accommodation_type_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function get_room_type($id)
    {
        $result = \DB::table('room_type')
            ->where('room_type_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function get_images_acc($id)
    {
        $result = \DB::table('acc_images')
            ->where('acc_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    // ------------------------------------------------------------------ Res ----------------------------------------------------------------

    public function getRes($data)
    {
        $result = \DB::table('restaurant')
            ->where('restaurant_id', array_get($data, 'res_id'))
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function get_images_res($id)
    {
        $result = \DB::table('res_images')
            ->where('res_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function get_res_type($id)
    {
        $result = \DB::table('restaurant_type')
            ->where('restaurant_type_id', $id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }
}
