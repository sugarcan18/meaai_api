<?php
namespace App\Facades\Website\Update;

use Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;

use App\Repositories\Website\Update\UpdateRepository as UpdateRepo;
use App\invoice_tour as InvoiceTour;
use App\transaction as Transaction;
use App\tour as Tour;

class UpdateClass{

	public function __construct(UpdateRepo $UpdateRepo){
		$this->UpdateRepo = $UpdateRepo;
  }
/* ------------------------------------
    Logic Update Information Booking
        1.Get Transtion ID & Informations
        2.Check ID to insert or update
        3.Insert new Guest of Transaction ID
        4.Update Guest of Transaction ID
  ------------------------------------ */
  public function updateinformationGuest($data){
    // 1.
    $transactionID = array_get($data,'transaction');
    $primary_guest = array_get($data,'primary_guest');
    $information_guest = array_get($data,'information');

    $transactionID = \GenerateCodeFacade::Decode($transactionID);

    $this->Update = new Transaction;

     //get transaction id
     $transaction = $this->UpdateRepo->getTransactionID($transactionID);
     if($transaction == 'false'){
         $this->Update->status= 'false';
         $this->Update->tittle= 'not have this Transaction ID';
         return $this->Update;
      }
 
     //get data transaction tour
     $transactionTour = $this->UpdateRepo->getTransactionTour($transaction[0]->id);
     if($transactionTour == 'false'){
         $this->Update->status= 'false';
         $this->Update->tittle= 'not have this Transaction Tour';
         return $this->Update;
      }
    
    //get data transaction tour Detail
    $transactionTourDetail = $this->UpdateRepo->getTransactionTourDetail($transactionTour[0]->id);
    //get data transaction tour Detail sub guest
    $transactionTourDetailsub = $this->UpdateRepo->getTransactionTourDetailGuest($transactionTour[0]->id);

    // 2.
    /*
    // primary Guest
        //Transaction Tour Detail
          $update_primary = $this->UpdateRepo->updateTransactionTourDetail_primary($transactionTour[0]->id,$primary_guest);
        //Guest
          $update_primary_ = $this->UpdateRepo->updateGuest_primary($transactionTour[0]->guest_id,$primary_guest);
    */
    // Sub Guest
    if(count($transactionTourDetail) == 1 ){
        //insert new infoemation Guest
          foreach($information_guest as $value){
              //guest
              $insertNewGuest = $this->UpdateRepo->insertNewGuest($value);
              //transaction tour detail
              $insertNewTourDetail = $this->UpdateRepo->insertNewTourDetail($transactionTour[0]->id,$value,$insertNewGuest);
          }
            if($insertNewTourDetail == 'true'){
              $this->Update->status = $insertNewTourDetail;
            }else{
              $this->Update->status = 'false';
            }
          
    }else{  
        //update information Guest
          foreach($information_guest as $index => $value){
              //transaction tour detail
              $updateDetail = $this->UpdateRepo->updateTourDetail($transactionTourDetailsub[$index]->guest_id,$value);
              //guest
              $updateGuest = $this->UpdateRepo->updateGuest($transactionTourDetailsub[$index]->guest_id,$value);
        }
          if($updateGuest == 'true'){
              $this->Update->status = $updateGuest;
            }else{
              $this->Update->status = 'false';
            }
    }
    return $this->Update;
  }
  
}