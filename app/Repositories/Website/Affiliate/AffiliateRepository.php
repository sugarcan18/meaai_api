<?php 
namespace App\Repositories\Website\Affiliate;

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

class AffiliateRepository{
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

  // ---------------- Check AFF ID on DataBase -----------------
  public function checkAffID($affid){
        $result = \DB::table('accounts')
                      ->where('token',$affid)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return 'true';
          }else{
            return 'false';
          }


  }

}

