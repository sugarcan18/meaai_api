<?php 
namespace App\Repositories\Website\Bookings;

use Carbon\Carbon;

use App\tour as Tour;
use App\configuration_tour_price as Configuration_tour_price;
use App\transaction as Transaction;
use App\transaction_tour as TransactionTour;
use App\transaction_tour_history as TransactionTourHistory;
use App\transaction_tour_detail as TransactionTourDetail;
use App\transaction_tour_detail_history as TransactionTourDetailHistory;
use App\guest as Guest;
use App\payment as Payment;
use App\invoice_tour as InvoiceTour;

class BookingRepository{
  public function __construct(Tour $Tour, Configuration_tour_price $Configuration_tour_price, Transaction $Transaction, TransactionTour $TransactionTour, TransactionTourHistory $TransactionTourHistory, TransactionTourDetail $TransactionTourDetail, Guest $Guest, Payment $Payment, InvoiceTour $InvoiceTour, TransactionTourDetailHistory $TransactionTourDetailHistory){
    $this->Tour = $Tour;
    $this->Configuration_tour_price = $Configuration_tour_price;
    $this->Transaction = $Transaction;
		$this->TransactionTour = $TransactionTour;		
		$this->TransactionTourHistory = $TransactionTourHistory;
		$this->TransactionTourDetail = $TransactionTourDetail;
		$this->TransactionTourDetailHistory = $TransactionTourDetailHistory;
		$this->Guest = $Guest;
		$this->Payment = $Payment;
		$this->InvoiceTour = $InvoiceTour;
  }

  // ---------------- Get Tour Price -----------------

  public function getTourId($tourcode){
          $result = \DB::table('tours')
                      ->where('code',$tourcode)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
  }

  public function getTourTime($tourid){
            $result = \DB::table('tour_travel_times')
                      ->where('tour_id',$tourid)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
  }

  public function getTourPrice($tourid){
          $result = \DB::table('configuration_tour_prices')
                      ->where('tour_id',$tourid)
                      ->where('payment_mode_id',1)
                      ->where('is_active',1)
                      ->get();
         if($result){
            return $result;
          }else{
            return 'false';
          }
  }
  
  public function getTourPax($tour_pax_id){
        $result = \DB::table('tour_paxes')
                      ->where('id',$tour_pax_id)
                      ->where('is_active',1)
                      ->get();
         if($result){
            return $result;
          }else{
            return 'false';
          }
  }

  // --------------------- Save Booking -------------------
  public function SaveTransactionBooking($bookinginfo,$guestinfo){
        $dateTimeNow = Carbon::now('Asia/Bangkok');
		    $dateNow = $dateTimeNow->format('Y-m-d');
        $timeNow = $dateTimeNow->format('H:i:s');

        //check hotel
        $hotel = array_get($guestinfo,'hotel');
        if($hotel == 'other'){
            $hotel = array_get($guestinfo,'hotel_other');
          }
        
        $transaction = [
          'account_id'=>0,
          'transaction_status_id'=>1,
          'customer_code_id'=>0,
          'payment_mode'=>array_get($bookinginfo,'payment_mode'),
          'payment_collect'=>array_get($bookinginfo,'payment_collect'),
          'book_by_name'=>array_get($guestinfo,'fullname'),
          'book_by_position'=>array_get($guestinfo,'position'),
          'book_by_hotel'=>$hotel,
          'book_by_tel'=>array_get($guestinfo,'phone'),
          'note_by'=>array_get($guestinfo,'fullname'),
          'book_date'=>$dateNow,
          'book_time'=>$timeNow,
          'commission'=>array_get($bookinginfo,'commission'),
          'discount'=>array_get($bookinginfo,'discount'),
          'service_charge'=>array_get($bookinginfo,'servicecharge'),
          'amount'=>array_get($bookinginfo,'total_price'),
          'insurance_note'=>array_get($bookinginfo,'insurance')==null?'':array_get($bookingInfo,'insurance'),
          'issued_by'=>array_get($bookinginfo,'issued_by'),
          'is_insurance'=>array_get($bookinginfo,'isIsinsurance')==true?1:0,
          'is_service_charge'=>array_get($bookinginfo,'isServicecharge')==true?1:0,
          'is_advance'=>0,
          'is_commission'=>array_get($bookinginfo,'isCommission')==true?1:0,
          'created_by'=>'Website',
          'created_at'=>$dateTimeNow
        ];
        return $this->Transaction->insertGetId($transaction);
  }

  public function SaveTransactionTourBooking($transactionId,$bookinginfo,$guestinfo){
        $dateTimeNow = Carbon::now('Asia/Bangkok');
		    $dateNow = $dateTimeNow->format('Y-m-d');
        $timeNow = $dateTimeNow->format('H:i:s');

        //check hotel
        $hotel = array_get($guestinfo,'hotel');
        if($hotel == 'other'){
            $hotel = array_get($guestinfo,'hotel_other');
        }
        //format travel date
        $travelDate_ = \DateFormatFacade::SetFullDate(array_get($bookinginfo,'date_travel'));
        $travelDate = date('Y-m-d',strtotime(array_get($bookinginfo,'date_travel')));

        $tour = [
			      'transaction_id'=>$transactionId,
			      'tour_id'=>array_get($bookinginfo,'tour_id'),
			      'tour_code'=>array_get($bookinginfo,'tour_code'),
			      'tour_title'=>array_get($bookinginfo,'tour_title'),
			      'tour_privacy'=>array_get($bookinginfo,'privacy'),
			      'tour_travel_time'=>array_get($bookinginfo,'tour_time'),
			      'tour_travel_date'=>$travelDate_,
			      'travel_date'=>$travelDate,
			      'rate_two_pax'=>0,
			      'pax'=>array_get($bookinginfo,'pax'),
			      'adult_pax'=>array_get($bookinginfo,'adult_pax'),
			      'child_pax'=>array_get($bookinginfo,'child_pax'),
			      'infant_pax'=>array_get($bookinginfo,'infant_pax'),
			      'single_riding_pax'=>0,
			      'single_riding'=>0,
			      'deposit_price'=>0,
			      'discount_rate'=>array_get($bookinginfo,'discount'),
			      'discount'=>array_get($bookinginfo,'discount_price'),
			      'adult_price'=>array_get($bookinginfo,'adult_price'),
			      'child_price'=>array_get($bookinginfo,'child_price'),
			      'total_adult_price'=>array_get($bookinginfo,'total_adult_price'),
			      'total_child_price'=>array_get($bookinginfo,'total_child_price'),
			      'total_price'=>array_get($bookinginfo,'total_price'),
			      'amount'=>array_get($bookinginfo,'total_price'),
			      'hotel'=>$hotel,
			      'hotel_room'=>'',
			      'created_by'=>'Website',
			      'created_at'=>$dateNow
		      ];
          return $this->TransactionTour->insertGetId($tour);
  }

  public function SaveBookingPayment($transactionId,$bookinginfo,$guestinfo){
        $dateTimeNow = Carbon::now('Asia/Bangkok');
		    $dateNow = $dateTimeNow->format('Y-m-d');
        $timeNow = $dateTimeNow->format('H:i:s');

        $payment = [
          'transaction_id'=>$transactionId,
          'payment_status_id'=>1,
          'payment_channel_id'=>1,
          'payment_mode_id'=>1,
          'amount'=>array_get($bookinginfo,'total_price'),
          'expired_date'=>null,
          'payment_date'=>null,
          'is_expired'=>0,
          'created_by'=>array_get($bookinginfo,'issued_by'),
          'created_at'=>$dateTimeNow
        ];
        return $this->Payment->insertGetId($payment);
  }

  public function SaveInvoiceTour($transactionId,$transactionTourId,$invoiceNumberData,$bookinginfo){

        $dateTimeNow = Carbon::now('Asia/Bangkok');
		    $dateNow = $dateTimeNow->format('Y-m-d');
        $timeNow = $dateTimeNow->format('H:i:s');

        $bookingNumber = [
          'transaction_id'=>$transactionId,
          'transaction_tour_id'=>$transactionTourId,
          'booking_number'=>array_get($invoiceNumberData,'bookingNumber'),
          'invoice_number'=>array_get($invoiceNumberData,'invoiceNumber'),
          'issued_by'=>array_get($bookinginfo,'issued_by'),
          'created_by'=>array_get($bookinginfo,'issued_by'),
          'created_at'=>$dateTimeNow
        ];
        return $this->InvoiceTour->insertGetId($bookingNumber);
  }

  public function GetLastInvoiceNumber(){
            $result = \DB::table('invoice_tours')
                                ->select('booking_number')
                                ->where('is_active',1)
                                ->orderBy('id','desc')
                                ->first();
                return response()->json($result);
  }

  public function SaveGuestData($bookinginfo,$guestinfo){
          $dateTimeNow = Carbon::now('Asia/Bangkok');
		      $dateNow = $dateTimeNow->format('Y-m-d');

          $guest = [
              'fullname'=>array_get($guestinfo,'fullname'),
              'firstname'=>array_get($guestinfo,'firstname'),
              'lastname'=>array_get($guestinfo,'lastname'),
              'email'=>array_get($guestinfo,'email'),
              'phone'=>array_get($guestinfo,'phone'),
			        'is_primary'=>1,
			        'created_by'=>array_get($bookinginfo,'issued_by'),
			        'created_at'=>$dateTimeNow
		];
		return $this->Guest->insertGetId($guest);
  }

  public function SaveTransactionTourDetail($transactionTourId,$bookinginfo,$guestinfo,$guestId){
		      $dateTimeNow = Carbon::now('Asia/Bangkok');
		      $dateNow = $dateTimeNow->format('Y-m-d');
		      $tourDetail = [
			          'transaction_tour_id'=>$transactionTourId,
			          'guest_id'=>$guestId,
                'fullname'=>array_get($guestinfo,'fullname'),
                'firstname'=>array_get($guestinfo,'firstname'),
                'lastname'=>array_get($guestinfo,'lastname'),
                'is_primary'=>1,
			          'created_by'=>array_get($bookinginfo,'issued_by'),
			          'created_at'=>$dateTimeNow
		          ];
              return $this->TransactionTourDetail->insertGetId($tourDetail);
  }

}

