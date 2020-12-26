<?php
namespace App\Facades\Users;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
//model
use App\users as users;
use App\Repositories\Users\UsersRepository as UsersRepo;

class UsersClass
{

    public function __construct(UsersRepo $UsersRepo)
    {
        $this->UsersRepo = $UsersRepo;
    }

    /*  Register logic
            1. Check email repeat
            2. Save accounts table
            3. Save account profile table
    */

    public function UserRegister($data)
    {
        $this->returnData = new users;

        $addUser = $this->UsersRepo->addUsers($data);
        if ($addUser === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, add user!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, add user!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function UserResetPass($data)
    {
        $this->returnData = new users;
        $email = array_get($data, 'email');

        $checkUser = $this->UsersRepo->checkUser($email);
        if ($checkUser === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'Not have, this Email !';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $reCode = $this->UsersRepo->addResetCode($checkUser);
        if ($reCode === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, save Reset Code!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $sendEmail = $this->sendEMail($checkUser[0]->email, $reCode);
        if ($sendEmail === 'true') {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, send code!';
            $this->returnData->data = $reCode;
            return $this->returnData;
        }
    }

    public function sendEMail($email, $recode)
    {

        $form = '<h2>Reset Code : </h2> <h4>' . $recode . '</h4>';

        $mail = new PHPMailer();

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $mail->isSMTP(true);
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sugarcan19@gmail.com';
            $mail->Password   = 'opor58291819';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Port       = 25;

            //Recipients
            $mail->setFrom('sugarcan19@gmail.com', 'Contact form Website');
            $mail->addAddress($email);


            // Content
            $mail->isHTML(true);
            $mail->Subject = 'MEAAI APP';
            $mail->Body = $form;

            $mail->send();
            return 'true';
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
        }
    }

    public function UserUpdatePass($data)
    {
        $this->returnData = new users;

        $update = $this->UsersRepo->updatePass($data);
        if ($update === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update password!';
            $this->returnData->data = '';
            return $this->returnData;
        }

        $this->returnData->status = 'true';
        $this->returnData->messages = 'success, Update password!';
        $this->returnData->data = '';
        return $this->returnData;
    }

    public function UserLogin($data)
    {
        $this->returnData = new users;
        $email = array_get($data, 'email');
        $pass = array_get($data, 'password');

        $checkUser = $this->UsersRepo->checkUser($email);
        if ($checkUser === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Email not have register!';
            $this->returnData->data = '';
            return $this->returnData;
        }
        if ($pass === $checkUser[0]->password) {
            $Login = $this->UsersRepo->Login($checkUser);

            $this->returnData->status = 'true';
            $this->returnData->messages = 'Login Success!';
            $this->returnData->data = $Login;
            return $this->returnData;
        } else {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Password Incorrect !';
            $this->returnData->data = '';
            return $this->returnData;
        }
    }

    public function UserLogOut($data)
    {
        $this->returnData = new users;
        $token_login = array_get($data, 'token_login');

        $logout = $this->UsersRepo->logout($token_login);
        if ($logout === 'true') {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, Logout!';
            $this->returnData->data = '';
            return $this->returnData;
        } else {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Logout!';
            $this->returnData->data = '';
            return $this->returnData;
        }
    }

    public function get_nationality(){
        $this->returnData = new users;

        $get_nationality = $this->UsersRepo->get_nationality();
        if ($get_nationality === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, nationality!';
            $this->returnData->data = '';
            return $this->returnData;
        } else {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, nationality!';
            $this->returnData->data = $get_nationality;
            return $this->returnData;
        }
    }

    public function get_users($token){
        $this->returnData = new users;

        $get_users = $this->UsersRepo->get_users($token);
        if ($get_users === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, get User!';
            $this->returnData->data = '';
            return $this->returnData;
        } else {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, get User!';
            $this->returnData->data = $get_users;
            return $this->returnData;
        }
    }

    public function update_profile($data){
        $this->returnData = new users;

        $update = $this->UsersRepo->update_profile($data);
        if ($update === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, Update Profile!';
            $this->returnData->data = '';
            return $this->returnData;
        } else {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, Update Profile!';
            $this->returnData->data = '';
            return $this->returnData;
        }

    }

    public function getacc(){
        $this->returnData = new users;

        $getAcc = $this->UsersRepo->getacc();
        if ($getAcc === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, get Acc!';
            $this->returnData->data = '';
            return $this->returnData;
        } else {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, get Acc!';
            $this->returnData->data = $getAcc;
            return $this->returnData;
        }

    }

    public function getres(){
        $this->returnData = new users;

        $geRes = $this->UsersRepo->getres();
        if ($geRes === 'false') {
            $this->returnData->status = 'false';
            $this->returnData->messages = 'error, get Res!';
            $this->returnData->data = '';
            return $this->returnData;
        } else {
            $this->returnData->status = 'true';
            $this->returnData->messages = 'success, get Res!';
            $this->returnData->data = $geRes;
            return $this->returnData;
        }

    }
}
