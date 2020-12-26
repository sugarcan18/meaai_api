<?php
namespace App\Facades\Website\Payment;

use Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
// require 'vendor/autoload.php';

use App\Repositories\Website\Payment\PaymentRepository as PaymentRepo;
use App\invoice_tour as InvoiceTour;
use App\transaction as Transaction;
use App\tour as Tour;

// require_once __DIR__ . '/vendor/autoload.php';

class PaymentClass{

	public function __construct(PaymentRepo $PaymentRepo){
		$this->PaymentRepo = $PaymentRepo;
  }
/* ------------------------------------
    Logic 
        1.check transaction ID
        2.get Invoice ID
        3.get Data by Payment ID
  ------------------------------------ */

  public function getDataPaymentID($data){
    $transactionID = array_get($data,'transaction');
    $transactionID = \GenerateCodeFacade::Decode($transactionID);

    $this->Payment = new Transaction;

    //check transaction ID
    $transaction = $this->PaymentRepo->checkTransactionID($transactionID);
    if($transaction == 'false'){
         $this->Payment->status = 'false';
         $this->Payment->title = 'not have this Transaction ID';
         return $this->Payment;
    }

    //get Invoice ID
    $invoice = $this->PaymentRepo->checkInvoice($transaction[0]->id);
    if($invoice == 'false'){
         $this->Payment->status= 'false';
         $this->Payment->title= 'not have this Transaction ID';
         return $this->Payment;
    }

    //get Data Payment ID
    $payment = $this->PaymentRepo->getPaymentID($transaction[0]->id);
    if($payment == 'false'){
         $this->Payment->status = 'false';
         $this->Payment->title = 'not have this Payment ID';
         return $this->Payment;
    }

    //set Data Payment to Client
    $this->Payment->payment_id = $payment[0]->id;
    $this->Payment->transction_id = $payment[0]->transaction_id;
    $this->Payment->invoice = $invoice[0]->invoice_number;
    $this->Payment->amount = $payment[0]->amount;

    return $this->Payment;
  }


  /* ------------------------------------
    Logic 
        1.update Payment ID
  ------------------------------------ */
  public function updatePaymentID($data){
     $this->Payment = new Transaction;
     $PaymentID = array_get($data,'payment_id');
     $Payment = $this->PaymentRepo->updatePaymentID($PaymentID);
     if($Payment == 'false'){
          $this->Payment->status = 'false';
          $this->Payment->title = 'Error Update this Payment';
          return $this->Payment;
     }
     $PDF = $this->genaratePDF($PaymentID);
     if($PDF == 'true'){
          $this->Payment->status = 'true';
          return $this->Payment;
     }else{
          $this->Payment->status = 'false';
          return $this->Payment;
     }
    // return $PDF;
  }

  public function genaratePDF($PaymentID){
     $dateTimeNow = Carbon::now('Asia/Bangkok');
	   $dateNow = $dateTimeNow->format('Y-m-d');
     $timeNow = $dateTimeNow->format('H:i:s');

     $payment = $this->PaymentRepo->getTransactionbyPaymentID($PaymentID);

     $transaction = $this->PaymentRepo->getTransactionID($payment[0]->transaction_id);

     $transactionTour = $this->PaymentRepo->getTransactionTour($transaction[0]->id);

     $transactionTourDetail = $this->PaymentRepo->getTransactionTourDetail($transactionTour[0]->id);

     $guest = $this->PaymentRepo->getDataGuest($transactionTourDetail[0]->guest_id);

     $invoice = $this->PaymentRepo->checkInvoice($transaction[0]->id);

     $filename  = time().'.pdf';
     
$html ='
<style type="text/css">
.font-logo {
    font-family: CenturyGothic400;
    src: url("{{ public_path("/fonts/CenturyGothic400.tff")}}");
}
</style>

<body style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; ">
<table style="width: 100%;">
  <tr>
    <td style="width: 80%;">
      <img style="width: 20%; height: auto" src="http://api.tourinchiangmai.com/images/logo-tc-52549811-1.png"><br>
      <span style="padding-left: 1%; font-size: 0.8rem;">14 1st Floor, Ratchadamnoen Rd.,</span><br> 
      <span style="padding-left: 1%; font-size: 0.8rem;">Soi 5, Sriphum, Muang,</span><br> 
      <span style="padding-left: 1%; font-size: 0.8rem;">Chiang Mai 50200 Thailand</span>   
    </td>
    <td style="width: 20%;"><span style="font-size: 4rem;color:red; ">RECEIPT</span></td>
  </tr>
  <tr>
    <td style="width: 80%;">
      <br><br>
      <span style="font-size: 1.1rem;"><b>Customer</b></span><br>
      <table>
      <tr>
        <td><span style="padding-left: 1%; font-size: 0.8rem;">Name</span></td>
        <td><span style="font-size: 0.8rem;">:</span></td>
        <td><span style="font-size: 0.8rem;"> <b>'.$guest[0]->fullname.'</b></span></td>
      </tr>
      <tr>
        <td><span style="padding-left: 1%; font-size: 0.8rem;">Email</span></td>
        <td><span style="font-size: 0.8rem;">:</span></td>
        <td><span style="font-size: 0.8rem;"> '.$guest[0]->email.'</span></td>
      </tr>
      <tr>
        <td><span style="padding-left: 1%; font-size: 0.8rem;">Phone</span></td>
        <td><span style="font-size: 0.8rem;">:</span></td>
        <td><span style="font-size: 0.8rem;"> '.$guest[0]->phone.'</span></td>
      </tr>
      <tr>
        <td><span style="padding-left: 1%; font-size: 0.8rem;">Hotel</span></td>
        <td><span style="font-size: 0.8rem;">:</span></td>
        <td><span style="font-size: 0.8rem;"> '.$transactionTour[0]->hotel.'</span></td>
      </tr>
  </table>
    </td>
    <td style="width: 20%;">
        <div style="border: 1px solid #333; padding: 2%;">
            <table style="font-size: 0.9rem;">
              <tr>
                <td>Receipt No.</td>
                <td> : </td>
                <td><span style="float: right;">'.$invoice[0]->invoice_number.'</span></td>
              </tr>
              <tr>
                <td>Receipt Date</td>
                <td> : </td>
                <td><span style="float: right;">'.$dateNow.'</span></td>
              </tr>
              <tr>
                <td>Status</td>
                <td> : </td>
                <td style="color:red"><b><span style="float: right;">PAID</span></b></td>
              </tr>
            </table>
        </div>
    </td>
  </tr>
</table>
      <br>
      <br>
      <table style="width: 100%; text-align: center; border-collapse: collapse;">
        <tr>
        <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 10%;"><span style="font-size: 0.9rem;">No.</span></td>
        <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 50%;"><span style="font-size: 0.9rem;">Description</span></td>
        <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 10%;"><span style="font-size: 0.9rem;">QTY</span></td>
        <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 15%;"><span style="float: right; font-size: 0.9rem;">Unit Price</span></td>
        <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 15%;"><span style="float: right; font-size: 0.9rem;">Amount</span></td>
        </tr>
          <tr>
            <td style="padding-top: 2%; font-size: 0.9rem;">1</td>
            <td style="padding-top: 2%; text-align:left; font-size: 0.9rem;">'.$transactionTour[0]->tour_title.' ( '.$transactionTour[0]->tour_privacy.' ) <br> '.$transactionTour[0]->tour_travel_time.' @ '.$transactionTour[0]->tour_travel_date.'</td>
            <td style="padding-top: 2%;"></td>
            <td style="padding-top: 2%;"></td>
          </tr>
          <tr style="font-size: 0.9rem;">
              <td></td>
              <td style="text-align:none;"><span style="font-size: 0.9rem;">Adult</span></td>
              <td><span style="font-size: 0.9rem;">'.$transactionTour[0]->adult_pax.'</span></td>
              <td><span style="float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->adult_price,2).'</span></td>
              <td><span style="float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->total_adult_price,2).'</span></td>
          </tr>
          <tr style="font-size: 0.9rem;">
              <td></td>
              <td style="text-align:none;"><span style="font-size: 0.9rem;">Child</span></td>
              <td><span style="font-size: 0.9rem;">'.$transactionTour[0]->child_pax.'</span></td>
              <td><span style="float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->child_price,2).'</span></td>
              <td><span style="float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->total_child_price,2).'</span></td>
          </tr>
          <tr style="font-size: 0.9rem;">
              <td style="padding: 0 0 3% 0;"></td>
              <td style="padding: 0 0 3% 0; text-align:none"><span style="font-size: 0.9rem;">Infant</span></td>
              <td style="padding: 0 0 3% 0;"><span style="font-size: 0.9rem;">'.$transactionTour[0]->infant_pax.'</span></td>
              <td style="padding: 0 0 3% 0; float: right;"><span style="float: right; font-size: 0.9rem;">0.00</span></td>
              <td style="padding: 0 0 3% 0; float: right;"><span style="float: right; font-size: 0.9rem;">0.00</span></td>
          </tr>
          <tr style="font-size: 0.9rem;">
              <td></td>
              <td></td>
              <td></td>
              <td colspan="2" style="border-top: 1px solid #000; padding: 0 0 1% 0;"></td>
              <td></td>
          </tr>
          <tr style="font-size: 0.9rem;">
              <td></td>
              <td></td>
              <td></td>
              <td style="font-size: 1.2rem;"><span style="font-size: 0.9rem;"><b>TOTAL</b></span></td>
              <td style="font-size: 1.2rem;"><span style="font-size: 0.9rem;"><b>'.number_format($transactionTour[0]->amount,2).' THB</b> </span></td>
          </tr>
        </table>
        <div style="margin-top: 10%; text-align: center; font-size: 0.9rem;">
          <span style="font-size: 1.2rem;">Thanks for booking tour with us.</span><br><br>
          <span style="text-align: justify; font-size: 0.9rem">
              Please do not hesitate to contact us if you have any questions.<br>
              Tel : +66(0)53 289 644
              E-mail : reservations@touringcnx.com, touringcenter@hotmail.com <br>
              Office Hour : 08:00 - 20:00 (Daily)
          </span>
          <br>
          <br>
          <br>
          <span style="color:red; font-size: 0.6rem;">The listed price does not include a 500THB & 1,000THB surcharge for pick up and drop off in hotel outside the city
            centre (6 km. from the 3 king monument). <br> The pick up surcharge is required by our local supplier and is not within our control.
          </span>
          <br><br>
          <span style="font-size: 0.6rem;"><b>Terms and Conditions</b><br>
            All sales are final and incur 100% cancellation penalties. <br>
            Any change less than 12 hours before the departure time, will be charged THB500.- per person
          </span>
      </div>
</body>
            ';


$email ='
<body style="padding: 5% 10%; border: 1px solid #333; font-family: Helvetica Neue,Helvetica,Arial,sans-serif; ">
<table style="width: 100%;">
<tr>
  <td style="width: 80%;">
    <img style="width: 20%; height: auto" src="http://api.tourinchiangmai.com/images/logo-tc-52549811-1.png"><br>
    <span style="padding-left: 1%; font-size: 0.8rem;">14 1st Floor, Ratchadamnoen Rd.,</span><br> 
    <span style="padding-left: 1%; font-size: 0.8rem;">Soi 5, Sriphum, Muang,</span><br> 
    <span style="padding-left: 1%; font-size: 0.8rem;">Chiang Mai 50200 Thailand</span>   
  </td>
  <td style="width: 20%;"><span style="font-size: 4rem;color:red; ">RECEIPT</span></td>
</tr>
<tr>
  <td style="width: 80%;">
    <br><br>
    <table>
            <tr>
              <td><span style="padding-left: 1%; font-size: 0.8rem;">Name</span></td>
              <td><span style="font-size: 0.8rem;">:</span></td>
              <td><span style="font-size: 0.8rem;"> <b>'.$guest[0]->fullname.'</b></span></td>
            </tr>
            <tr>
              <td><span style="padding-left: 1%; font-size: 0.8rem;">Email</span></td>
              <td><span style="font-size: 0.8rem;">:</span></td>
              <td><span style="font-size: 0.8rem;"> '.$guest[0]->email.'</span></td>
            </tr>
            <tr>
              <td><span style="padding-left: 1%; font-size: 0.8rem;">Phone</span></td>
              <td><span style="font-size: 0.8rem;">:</span></td>
              <td><span style="font-size: 0.8rem;"> '.$guest[0]->phone.'</span></td>
            </tr>
            <tr>
              <td><span style="padding-left: 1%; font-size: 0.8rem;">Hotel</span></td>
              <td><span style="font-size: 0.8rem;">:</span></td>
              <td><span style="font-size: 0.8rem;"> '.$transactionTour[0]->hotel.'</span></td>
            </tr>
        </table>
  </td>
  <td style="width: 20%;">
      <div style="border: 1px solid #333; padding: 2%;">
          <table style="font-size: 0.9rem;">
            <tr>
              <td>Receipt No.</td>
              <td> : </td>
              <td><a href="https://dev-new.tour-in-chiangmai.com/#/receipt/'.\GenerateCodeFacade::Encode($payment[0]->transaction_id).'">'.$invoice[0]->invoice_number.'</a></td>
            </tr>
            <tr>
              <td>Receipt Date</td>
              <td> : </td>
              <td>'.$dateNow.'</td>
            </tr>
            <tr>
              <td>Status</td>
              <td> : </td>
              <td style="color:red"><b>PAID</b></td>
            </tr>
          </table>
      </div>
  </td>
</tr>
</table>
    <br>
    <br>
    <table style="width: 100%; text-align: center; border-collapse: collapse;">
      <tr>
      <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 10%;"><span style="font-size: 0.9rem;">No.</span></td>
      <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 50%;"><span style="font-size: 0.9rem;">Description</span></td>
      <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 10%;"><span style="font-size: 0.9rem;">QTY</span></td>
      <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 15%;"><span style="float: right; font-size: 0.9rem;">Unit Price</span></td>
      <td style="border-top: 1px solid #dddddd; border-bottom: 1px solid #dddddd; padding: 1%; width: 15%;"><span style="float: right; font-size: 0.9rem;">Amount</span></td>
      </tr>
        <tr>
          <td style="padding-top: 2%; font-size: 0.9rem;">01</td>
          <td style="padding-top: 2%; text-align:left; font-size: 0.9rem;">'.$transactionTour[0]->tour_title.' ( '.$transactionTour[0]->tour_privacy.' ) <br> '.$transactionTour[0]->tour_travel_time.' @ '.$transactionTour[0]->tour_travel_date.'</td>
          <td style="padding-top: 2%;"></td>
          <td style="padding-top: 2%;"></td>
        </tr>
        <tr style="font-size: 0.9rem;">
            <td></td>
            <td style="text-align:none;"><span style="font-size: 0.9rem;">Adult</span></td>
            <td><span style="font-size: 0.9rem;">'.$transactionTour[0]->adult_pax.'</span></td>
            <td style="float: right;"><span style="float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->adult_price,2).'</span></td>
            <td style="float: right;"><span style="float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->total_adult_price,2).'</span></td>
        </tr>
        <tr style="font-size: 0.9rem;">
            <td></td>
            <td style="text-align:none;"><span style="font-size: 0.9rem;">Child</span></td>
            <td><span style="font-size: 0.9rem;">'.$transactionTour[0]->child_pax.'</span></td>
            <td><span style="float: right; float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->child_price,2).'</span></td>
            <td><span style="float: right; float: right; font-size: 0.9rem;">'.number_format($transactionTour[0]->total_child_price,2).'</span></td>
        </tr>
        <tr style="font-size: 0.9rem;">
            <td style="padding: 0 0 3% 0;"></td>
            <td style="padding: 0 0 3% 0; text-align:none"><span style="font-size: 0.9rem;">Infant</span></td>
            <td style="padding: 0 0 3% 0;"><span style="font-size: 0.9rem;">'.$transactionTour[0]->infant_pax.'</span></td>
            <td style="padding: 0 0 3% 0; float: right;"><span style="float: right; font-size: 0.9rem;">0.00</td>
            <td style="padding: 0 0 3% 0; float: right;"><span style="float: right; font-size: 0.9rem;">0.00</span></td>
        </tr>
        <tr style="font-size: 0.9rem;">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" style="border-top: 1px solid #000; padding: 0 0 1% 0;"></td>
            <td></td>
        </tr>
        <tr style="font-size: 0.9rem;">
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size: 1.2rem;"><span style="font-size: 0.9rem;">TOTAL</span></td>
            <td style="font-size: 1.2rem;"><span style="font-size: 0.9rem;"><b>'.number_format($transactionTour[0]->amount,2).' </b>THB</span></td>
        </tr>
      </table>
      <div style="margin-top: 10%; text-align: center; font-size: 0.9rem;">
        <span style="font-size: 1.2rem;">Thanks for booking tour with us.</span><br><br>
        <span style="text-align: justify; font-size: 0.8rem">
            Please do not hesitate to contact us if you have any questions.<br>
            Tel : +66(0)53 289 644
            E-mail : reservations@touringcnx.com, touringcenter@hotmail.com <br>
            Office Hour : 08:00 - 20:00 (Daily)
        </span>
        <br>
        <br>
        <br>
        <span style="color:red; font-size: 0.6rem;">The listed price does not include a 500THB & 1,000THB surcharge for pick up and drop off in hotel outside the city
          centre (6 km. from the 3 king monument). <br> The pick up surcharge is required by our local supplier and is not within our control.
        </span>
        <br><br>
        <span style="font-size: 0.6rem;"><b>Terms and Conditions</b><br>
          All sales are final and incur 100% cancellation penalties. <br>
          Any change less than 12 hours before the departure time, will be charged THB500.- per person
        </span>
    </div>
            ';


     $mpdf = new \Mpdf\Mpdf();
     $mpdf->WriteHTML($html);
     $path = 'PDF/receipt/'.$filename;
     $mpdf->Output($path, 'F');
     $tagReceiptPDF = $this->PaymentRepo->tagReceiptPDF($transaction[0]->id,$transactionTour[0]->id,$transactionTourDetail[0]->id,$filename);



     // --------------- Send Email ------------------
      $mail = new PHPMailer();

      try {
          //Server settings
          // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
          $mail->isSMTP(true);                                            // Send using SMTP
          $mail->Host       = 'mail.touringcnx.com';                    // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'reservations@touringcnx.com';                     // SMTP username
          $mail->Password   = '@TC-[rsvn]-201804';                               // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged ENCRYPTION_STARTTLS
          $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );
          $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      
          //Recipients
          $mail->setFrom('reservations@touringcnx.com', 'reservations');
          $mail->addAddress($guest[0]->email, $guest[0]->fullname); 
          $mail->addAddress('reservations@touringcnx.com');     // Add a recipient
          // $mail->addAddress('sugarcan19@gmail.com');               // Name is optional
          // $mail->addAddress('it@touringcnx.com');
          // $mail->addReplyTo('sugarcan18@hotmail.com', 'reservations');
      
          // Attachments
          $mail->addAttachment('PDF/receipt/'.$filename);         // Add attachments
          // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');        // Optional name
      
          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = 'Touring Center';
          $mail->Body = $email;

          $mail->send();
          return 'true';
      } catch (Exception $e) {
          return 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
      }

     //  $strSubject = "Touring Center";
     //  $strSubject .= "Reservation System (Paid)";
     //  $strHeader = "MIME-Version: 1.0' . \r\n";
     //  $strHeader .= "Content-type: text/html; charset=utf-8\r\n";
     //  $strHeader .= "From: reservations@touringcnx.com";
     //  $passenger_email = $guest[0]->email;
     //  $sendmail = mail($passenger_email,$strSubject,$html,$strHeader);
     //  if($sendmail){
          // $it_team_email = "it@touringcnx.com";
          // $sendmail = mail($it_team_email ,$strSubject,$html,$strHeader);
     //      return 'true';
     //    }else{
     //      return 'false';
     //    }

  }

}