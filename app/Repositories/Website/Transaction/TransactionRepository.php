<?php 
namespace App\Repositories\Website\Transaction;

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

class TransactionRepository{
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

	// ---------------- Get Transaction -----------------
		public function getTransactionID($transactionID){
				$result = \DB::table('transactions')
                      ->where('id',$transactionID)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
    }
    
    // ---------------- Get Transaction Tour -----------------
    public function getTransactionTour($transactionID){
				$result = \DB::table('transaction_tours')
                      ->where('transaction_id',$transactionID)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
    }

    // ---------------- Get Transaction Tour Detail -----------------
    public function getTransactionTourDetail($transactionTourID){
        $result = \DB::table('transaction_tour_details')
                      ->where('transaction_tour_id',$transactionTourID)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
    }

    // ---------------- Get Guest -----------------
    public function getDataGuest($transactionTourDetailID){
        $result = \DB::table('guests')
                      ->where('id',$transactionTourDetailID)
                      ->where('is_primary',1)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
    }

    // ---------------- Get Sub Guest Transaction Tour Detail -----------------
    public function getTransactionTourDetailGuest($transactionTourID){
        $result = \DB::table('transaction_tour_details')
                      ->where('transaction_tour_id',$transactionTourID)
											->where('is_active',1)
											->where('is_primary',0)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
    }

    // --------------- get PDF ID Name---------------------------------------
    public function getPDF($transactionTourID){
          $result = \DB::table('documents')
                      ->where('transaction_id',$transactionTourID)
											->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
    }

}

