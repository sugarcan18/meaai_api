<?php
namespace App\Facades\Website\Bookings;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Repositories\Website\Bookings\BookingRepository as BookingRepo;
use App\invoice_tour as InvoiceTour;
use App\transaction as Transaction;
use App\tour as Tour;

class BookingClass{

	public function __construct(BookingRepo $BookingRepo){
		$this->BookingRepo = $BookingRepo;
  }
/* ------------------------------------
    Logic get Tours Price
        1.check tour code & get id
        2.get tours price rate ( selling price )
        3.get tours time
        4.set Tours Price for return Value
  ------------------------------------ */
  public function getTourPriceRate($data){
    $this->getRatePrice = new Tour;
    $this->join = new Tour;
    $this->privacy= new Tour;
    $time = [];
    $privacy = [];
    $join = [];
    $private = [];

    $tourcode =  array_get($data,'TourCode');

    // 1.
    $tourid = $this->BookingRepo->getTourId($tourcode);
    if($tourid == 'false'){
        $this->getRatePrice->status= 'false';
        $this->getRatePrice->tittle= 'not have this tour in database';
        return $this->getRatePrice;
     }

    //  2.
    $tour_price = $this->BookingRepo->getTourPrice($tourid[0]->id);
    if($tour_price == 'false'){
        $this->getRatePrice->status= 'false';
        $this->getRatePrice->tittle= 'not have this Tour Price in database';
        return $this->getRatePrice;
     }

    // 3.
    $tour_time = $this->BookingRepo->getTourTime($tourid[0]->id);
    if($tour_time == 'false'){
      $this->getRatePrice->status= 'false';
      $this->getRatePrice->tittle= 'not have This Tour time in database';
      return $this->getRatePrice;
    }
      foreach($tour_time as $value){
        $this->tourtime= new Tour;
        $this->tourtime->meridiem = $value->meridiem;
        $this->tourtime->travel_time_start = $value->travel_time_start;
        $this->tourtime->travel_time_end = $value->travel_time_end;
        array_push($time , $this->tourtime);
      }
      $this->getRatePrice->tourtime = $time;

    //  4.
     $this->getRatePrice->tour_id = $tourid[0]->id;
     $this->getRatePrice->tour_code = $tourid[0]->code;
     $this->getRatePrice->tour_title = $tourid[0]->title;
    
     foreach($tour_price as $value){
       // Join
       if($value->tour_privacy_id == 1){
              $this->join->adult = $value->sell_price_adult;
              $this->join->child = $value->sell_price_child;
              $this->privacy->join = $this->join;              
       }
       // Private
       if($value->tour_privacy_id == 2){
              $this->private = new Tour;
              $pax = $this->BookingRepo->getTourPax($value->tour_pax_id);
              $this->private->pax = $pax[0]->min_pax.'-'.$pax[0]->max_pax;
              $this->private->adult = $value->sell_price_adult;
              $this->private->child = $value->sell_price_child;
              array_push($private , $this->private);    
        }

     }
        $this->privacy->private = $private;
        $this->getRatePrice->privacy = $this->privacy;
        return $this->getRatePrice;
  }


  /* ------------------------------------
	 	Logic save booking 
			1. transaction
			2. transaction_tour
			4. transaction_tour_history
			3. guest
			4. transaction_tour_detail
			5. transaction_tour_detail_history
			6. payment
			7. invoice_tour
			8. job_order
	------------------------------------ */
  public function saveBooking($data){
    $bookinginfo = array_get($data,'bookingInfo');
    $guestinfo = array_get($data, 'guestInfo');
    $this->booking = new Transaction;
    
    // Transaction
    $saveTransactionId = $this->BookingRepo->SaveTransactionBooking($bookinginfo,$guestinfo);
    $this->booking->Transaction = \GenerateCodeFacade::Encode($saveTransactionId);

    // Transaction tour
    $TransactionTourId = $this->BookingRepo->SaveTransactionTourBooking($saveTransactionId,$bookinginfo,$guestinfo);
    // $this->booking->TransactionTour = \GenerateCodeFacade::Encode($TransactionTourId);
    
    // Payment
    $PaymentId = $this->BookingRepo->SaveBookingPayment($saveTransactionId,$bookinginfo,$guestinfo);
    // $this->booking->Payment = \GenerateCodeFacade::Encode($PaymentId);

    // Invoice ---------------------
    // Get booking number
    $bookingNumber = $this->BookingRepo->GetLastInvoiceNumber();

    $this->InvoiceTour = new InvoiceTour;
    // return $bookingNumber;
		// Run invoice number
    $this->RunInvoiceNumber($bookingNumber);
    $Invoice = $this->BookingRepo->SaveInvoiceTour($saveTransactionId,$TransactionTourId,$this->InvoiceTour,$bookinginfo);
    // $this->booking->Invoice = \GenerateCodeFacade::Encode($Invoice);

    // Guest
    $guestId = $this->BookingRepo->SaveGuestData($bookinginfo,$guestinfo);
    // $this->booking->Guest = \GenerateCodeFacade::Encode($guestId);

		// Tour detail
    $TransactionTourDetailId = $this->BookingRepo->SaveTransactionTourDetail($TransactionTourId,$bookinginfo,$guestinfo,$guestId);
    // $this->booking->TransactionTourDetail = \GenerateCodeFacade::Encode($TransactionTourDetailId);

    if(!empty($saveTransactionId) && !empty($TransactionTourId ) && !empty($PaymentId) && !empty($Invoice) && !empty($guestId) && !empty($TransactionTourDetailId)){
       $this->booking->status = 'true';
       return $this->booking;
    }else{
       $this->booking->status = 'false';
       return $this->booking;
    }

   
  }

  	// run booking and invoice number
	public function RunInvoiceNumber($bookingNumber){
		$invoice = new InvoiceTour;

		// set date
		$yearNow = date('Y')+543;
		$monthNow = date('m');

		$subYearNow = substr($yearNow,2,2);
		// $subYearNow = 80;
		// $monthNow = 12;

		// Check empty
		if(empty($bookingNumber->booking_number)){
			$setBookingNumber = $subYearNow.'-'.$monthNow.'-001';
			$setInvoiceNumber = 'DT-'.$setBookingNumber;
		}else{
			// Sub booking number
			$subRunYear = substr($bookingNumber->booking_number,0,2);
			$subRunMonth = substr($bookingNumber->booking_number,3,2);
			$subRunNumber = intval(substr($bookingNumber->booking_number,6,3));

			if($subRunYear!=$subYearNow){
				// if($subRunMonth!=$monthNow){
					$setBookingNumber = $subYearNow.'-'.$monthNow.'-001';
					$setInvoiceNumber = 'DT-'.$setBookingNumber;
				// }else{
				// 	$runNumber = $subRunNumber+1;
				// 	$invRunNumber = str_pad($runNumber, 3, "0", STR_PAD_LEFT);

				// 	$setBookingNumber = $subYearNow.'-'.$monthNow.'-'.$invRunNumber;
				// 	$setInvoiceNumber = 'DT-'.$setBookingNumber;
				// }
			}else{
				if($subRunMonth!=$monthNow){
					$setBookingNumber = $subYearNow.'-'.$monthNow.'-'.'001';
					$setInvoiceNumber = 'DT-'.$setBookingNumber;
				}else{
					$runNumber = $subRunNumber+1;
					$invRunNumber = str_pad($runNumber, 3, "0", STR_PAD_LEFT);

					$setBookingNumber = $subYearNow.'-'.$monthNow.'-'.$invRunNumber;
					$setInvoiceNumber = 'DT-'.$setBookingNumber;
				}
			}
		}
		$invoice->bookingNumber = $setBookingNumber;
		$invoice->invoiceNumber = $setInvoiceNumber;

		return $this->InvoiceTour = $invoice;
  }
}