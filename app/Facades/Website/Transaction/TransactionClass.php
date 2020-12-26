<?php
namespace App\Facades\Website\Transaction;

use Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;

use App\Repositories\Website\Transaction\TransactionRepository as TransactionRepo;
use App\invoice_tour as InvoiceTour;
use App\transaction as Transaction;
use App\tour as Tour;

class TransactionClass{

	public function __construct(TransactionRepo $TransactionRepo){
		$this->TransactionRepo = $TransactionRepo;
  }
/* ------------------------------------
    Logic get Tours Price
        1.get transaction ID
        2.get data transaction tour by id
        3.set data to client
  ------------------------------------ */
  public function getDataTransactionID($data){

    $transactionID = array_get($data,'transaction');

    $transactionID = \GenerateCodeFacade::Decode($transactionID);

    $this->Transaction = new Transaction;

    //get transaction id
    $transaction = $this->TransactionRepo->getTransactionID($transactionID);
    if($transaction == 'false'){
        $this->Transaction->status= 'false';
        $this->Transaction->tittle= 'not have this Transaction ID';
        return $this->Transaction;
     }

    //get data transaction tour
    $transactionTour = $this->TransactionRepo->getTransactionTour($transaction[0]->id);
    if($transactionTour == 'false'){
        $this->Transaction->status= 'false';
        $this->Transaction->tittle= 'not have this Transaction Tour';
        return $this->Transaction;
     }

    //get data transaction tour detail (guest)
    $transactionTourDetail = $this->TransactionRepo->getTransactionTourDetail($transactionTour[0]->id);
    if($transactionTourDetail == 'false'){
        $this->Transaction->status= 'false';
        $this->Transaction->tittle= 'not have this Transaction Tour Detail';
        return $this->Transaction;
     }

    //get data Guest (guest)
    $guest = $this->TransactionRepo->getDataGuest($transactionTourDetail[0]->guest_id);
    if($guest == 'false'){
        $this->Transaction->status= 'false';
        $this->Transaction->tittle= 'not have this Guest';
        return $this->Transaction;
     }
     
    //set Data to Client
    $this->Transaction->tour_id = $transactionTour[0]->tour_id;
    $this->Transaction->tour_code = $transactionTour[0]->tour_code;
    $this->Transaction->tour_title = $transactionTour[0]->tour_title;
    $this->Transaction->privacy = $transactionTour[0]->tour_privacy;
    $this->Transaction->tour_travel_time = $transactionTour[0]->tour_travel_time;
    $this->Transaction->tour_travel_date = $transactionTour[0]->tour_travel_date;
    $this->Transaction->travel_date = $transactionTour[0]->travel_date;
    $this->Transaction->pax = $transactionTour[0]->pax;
    $this->Transaction->adult_pax = $transactionTour[0]->adult_pax;
    $this->Transaction->child_pax = $transactionTour[0]->child_pax;
    $this->Transaction->infant_pax = $transactionTour[0]->infant_pax;
    $this->Transaction->deposit_price = $transactionTour[0]->deposit_price;
    $this->Transaction->discount = $transactionTour[0]->discount;
    $this->Transaction->discount_rate = $transactionTour[0]->discount_rate;
    $this->Transaction->adult_price = $transactionTour[0]->adult_price;
    $this->Transaction->child_price = $transactionTour[0]->child_price;
    $this->Transaction->total_adult_price = $transactionTour[0]->total_adult_price;
    $this->Transaction->total_child_price = $transactionTour[0]->total_child_price;
    $this->Transaction->total_price = $transactionTour[0]->total_price;
    $this->Transaction->amount = $transactionTour[0]->amount;
    $this->Transaction->hotel = $transactionTour[0]->hotel;
    $this->Transaction->guest_id = $guest[0]->id;
    $this->Transaction->fullname = $guest[0]->fullname;
    $this->Transaction->firstname = $guest[0]->firstname;
    $this->Transaction->lastname = $guest[0]->lastname;
    $this->Transaction->email = $guest[0]->email;
    $this->Transaction->phone = $guest[0]->phone;
    $this->Transaction->book_date = $transaction[0]->book_date;
    $this->Transaction->book_time = $transaction[0]->book_time;
    $this->Transaction->issued_by = $transaction[0]->issued_by;
    $this->Transaction->created_by = $transaction[0]->created_by;
    $this->GetTransactionTourDetailsubGuest($transactionTour[0]->id);

    return $this->Transaction;
  }

  public function GetTransactionTourDetailsubGuest($TransactionTourID){
    $sub_guest = [];
    $transactionTourDetailsub = $this->TransactionRepo->getTransactionTourDetailGuest($TransactionTourID);
    if($transactionTourDetailsub == 'false'){
      $this->Transaction->sub_guest = '';
    }else{
      foreach($transactionTourDetailsub as $value){
        $this->sub_guest = new Tour;
          $this->sub_guest->fullname = $value->fullname;
          array_push($sub_guest , $this->sub_guest);
      }
      $this->Transaction->sub_guest = $sub_guest;
    }
  }

  public function getReceiptPDFID($data){
    $transactionID = array_get($data,'transaction');

    $transactionID = \GenerateCodeFacade::Decode($transactionID);

    $this->pdf_file = new Tour;

    $pdf = $this->TransactionRepo->getPDF($transactionID);
    $this->pdf_file->pdf = $pdf[0]->receipt;
    return $this->pdf_file;
  }
  
}