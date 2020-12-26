<?php 
namespace App\Repositories\Users;

use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

use Illuminate\Support\Str;

//model
use App\users as Users;
use App\history_login as History_login;
use App\reset_code as ResetCode;

class UsersRepository
{

    public function __construct(
        Users $Users,
        ResetCode $ResetCode,
        History_login $History_login
    ) {
        $this->Users = $Users;
        $this->ResetCode = $ResetCode;
        $this->History_login = $History_login;
    }

    public function checkUser($email)
    {
        $result = \DB::table('users')
            ->where('email', $email)
            ->where('isActive', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }
    public function addUsers($data)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');
        $timeNow = $dateTimeNow->format('H:i:s');
        $uuid = Uuid::generate(1);
        $users = [
            'user_id' =>  $uuid,
            'username' => array_get($data, 'fullname'),
            'password' => array_get($data, 'password'),
            'birth' => array_get($data, 'birthday'),
            'email' => array_get($data, 'email'),
            'type_user_id' => '1',
            'isActive' => '1'
        ];

        $result = $this->Users->insertGetId($users);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function addResetCode($user)
    {
        $users = [
            'user_id' =>  $user[0]->user_id,
            'email' => $user[0]->email,
            'reset_code' => Str::random(8),
            'is_active' => '1'
        ];

        $result = $this->ResetCode->insertGetId($users);

        if ($result) {
            return $users["reset_code"];
        } else {
            return 'false';
        }
    }

    public function updatePass($data)
    {
        $update = [
            'password' => array_get($data, 'pass')
        ];

        $result = $this->Users->where('email', array_get($data, 'email'))->update($update);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function Login($user)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $uuid = Uuid::generate(1);
        $login = [
            'user_id' =>  $uuid,
            'token_login' => $uuid,
            'user_id' => $user[0]->user_id,
            'username' => $user[0]->username,
            'email' => $user[0]->email,
            'type_user_id' => $user[0]->type_user_id,
            'login_datetime' => $dateTimeNow,
        ];

        $result = $this->History_login->insertGetId($login);

        if ($result) {
            $Login = $this->gethisLogin($result);
            return $Login;
        } else {
            return 'false';
        }
    }

    public function gethisLogin($id)
    {
        $result = \DB::table('history_login')
            ->where('id', $id)
            ->get();
        return $result;
    }

    public function logout($token_logout)
    {
        $update = [
            'is_active' => 0
        ];

        $result = $this->History_login->where('token_login', $token_logout)->update($update);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function get_nationality()
    {
        $result = \DB::table('countries')->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function get_users($token)
    {
        $result = \DB::table('history_login')
            ->where('token_login', array_get($token, 'token_login'))
            ->get(['user_id']);
        if ($result) {
            $result_ = $this->get_user($result[0]->user_id);
            return $result_;
        } else {
            return 'false';
        }
    }

    public function get_user($user_id)
    {
        $result = \DB::table('users')
            ->where('user_id', $user_id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function update_profile($data)
    {
        $update = [
            'username' => array_get($data, 'fullname'),
            'email' => array_get($data, 'email'),
            'password' => array_get($data, 'password'),
            'birth' => array_get($data, 'birthday'),
            'phone' => array_get($data, 'phone'),
            'nationality' => array_get($data, 'nationality'),
        ];

        $result = $this->Users->where('user_id', array_get($data, 'user_id'))->update($update);

        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function getacc()
    {
        $result = \DB::table('accommodation')
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    public function getres()
    {
        $result = \DB::table('restaurant')
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }
}
