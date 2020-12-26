<?php
namespace App\Facades\Website\Email;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Repositories\Website\Bookings\BookingRepository as BookingRepo;
use App\invoice_tour as InvoiceTour;
use App\transaction as Transaction;
use App\tour as Tour;
use App\Repositories\Website\Email\EmailRepository as EmailRepo;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailClass{

	public function __construct(BookingRepo $BookingRepo , EmailRepo $EmailRepo){
    $this->BookingRepo = $BookingRepo;
    $this->EmailRepo = $EmailRepo;
  }
/* ------------------------------------
    Logic send Email Contact from Guest
        1. get Data contact
        2. form email
        3. send Email
        4. return res
  ------------------------------------ */
  public function sendEmail($data){

    // 1.
    $fullname = array_get($data,'Fullname');
    $email = array_get($data,'Email');
    $message = array_get($data,'Message');

    // 2.
$form = '
    <body style="background-color: #fff;">
    <div style="background-color:  #e6e6e6; margin: 5%; height: auto;">
        <div style="padding: 5%;">
            <div style="text-align: center;">
              <span style="font-size: 3rem;">EMAIL CONTACT</span>
            </div>
            <div style="padding:6% 3%">
                <p>Name : <a style="color: #5c00e6">'.$fullname.'</a></p>
                <hr>
                <p>Email : <a style="color: #5c00e6">'.$email.'</a></p>
                <hr>
                <p>Message : <a style="color: #5c00e6">'.$message.'</a></p>
            </div>
            <div style="padding-top: 5%; text-align: center;">
              from <br>
              <a href="https://tour-in-chiangmai.com/"><span>www.tour-in-chiangmai.com</span></a><br><br>
              ( website )
            </div>
        </div>
    </div>
';


    // 3.

    $mail = new PHPMailer();

    try {
          //Server settings
          // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
          $mail->isSMTP(true);                                            // Send using SMTP
          $mail->Host       = 'mail.touringcnx.com';                    // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'reservations@touringcnx.com';                     // SMTP username
          $mail->Password   = '@TC-[rsvn]-201804';                               // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );
          $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      
          //Recipients
          $mail->setFrom('it@touringcnx.com', 'Contact form Website');
          $mail->addAddress('sugarcan19@gmail.com');     // Add a recipient
          $mail->addAddress('it@touringcnx.com');
          $mail->addReplyTo($email, $fullname);
      
          // Attachments
          // $mail->addAttachment('PDF/confirmation/'.$filename);         // Add attachments
          // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');        // Optional name
      
          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Touring Center';
          $mail->Body = $form;

          $mail->send();
          return 'true';
      } catch (Exception $e) {
          return 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
      }

  }

  /* ------------------------------------
    Logic Subscribe Email
        1. get Data contact
        2. form email
        3. send Email
        4. return res
  ------------------------------------ */
  // SubScribe
  public function subscribe($data){
    $guestinfo = array_get($data, 'guestInfo');

    $this->subscribe = new Tour;

    //check email subscribe
    $check = $this->EmailRepo->checkEmailsubScribe($guestinfo);
    if($check == 'true'){
      $this->subscribe->status= 'true';
      $this->subscribe->title= 'This Email have ready Subscribe!';
      return $this->subscribe;
    }

    // Guest subScribe
    $guestId = $this->EmailRepo->SaveGuestsubScribe($guestinfo);
    if($guestId == 'false'){
      $this->subscribe->status= 'false';
      $this->subscribe->title= 'Error Subscribe, Contact us to help.';
      return $this->subscribe;
    }

      $this->subscribe->status= 'true';
      $this->subscribe->title= 'Success Subscribe, Thank You.';
      return $this->subscribe;
  }

}