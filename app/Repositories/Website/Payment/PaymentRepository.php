<?php 
namespace App\Repositories\Website\Payment;

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
use App\document as Document;

class PaymentRepository{
  public function __construct(Tour $Tour, Configuration_tour_price $Configuration_tour_price, Transaction $Transaction, TransactionTour $TransactionTour, TransactionTourHistory $TransactionTourHistory, TransactionTourDetail $TransactionTourDetail, Guest $Guest, Payment $Payment, InvoiceTour $InvoiceTour, TransactionTourDetailHistory $TransactionTourDetailHistory, Document $Document){
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
    $this->Document = $Document;
	}
	
	// ---------------- Check Transaction ID ----------------
	public function checkTransactionID($transactionID){
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

	// ---------------- Get Invoice ----------------
	public function checkInvoice($transactionID){
				$result = \DB::table('invoice_tours')
                      ->where('transaction_id',$transactionID)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
	}

	// ---------------- Get Data Payment -----------------
	public function getPaymentID($transactionID){
			$result = \DB::table('payments')
											->where('transaction_id',$transactionID)
											->where('payment_status_id',1)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
  }

  // ---------------- Get Transaction ID by Payment ID -----------------
  public function getTransactionbyPaymentID($PaymentID){
      $result = \DB::table('payments')
											->where('id',$PaymentID)
											->where('payment_status_id',2)
                      ->where('is_active',1)
                      ->get();
          if($result){
            return $result;
          }else{
            return 'false';
          }
  }

  // ----------------- Tag Payment Receipt --------------------
  public function tagReceiptPDF($transaction,$transactionTour,$transactionTourDeail,$receipt){
      $dateTimeNow = Carbon::now('Asia/Bangkok');
		  $dateNow = $dateTimeNow->format('Y-m-d');
      $timeNow = $dateTimeNow->format('H:i:s');

      $receipt = [
              'transaction_id'=>$transaction,
              'transaction_tour_id'=>$transactionTour,
              'transaction_tour_detail_id'=>$transactionTourDeail,
              'receipt'=>$receipt,
              'is_active'=>1,
			        'issue_by'=>1,
			        'created_at'=>$dateTimeNow,
		  ];
		return $this->Document->insertGetId($receipt);
  }
  
  public function updatePaymentID($paymentID){
      $dateTimeNow = Carbon::now('Asia/Bangkok');
		  $dateNow = $dateTimeNow->format('Y-m-d');
      $timeNow = $dateTimeNow->format('H:i:s');

      $payment = [
        'payment_status_id'=>2,
        'updated_by'=>'Website',
        'updated_at'=>$dateTimeNow
       ];

      $result = $this->Payment->where('id',$paymentID)->update($payment);
      if($result){
        return 'true';
      }else{
        return 'false';
      }
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

public function getDataGuest($transactionTourDetailID){
    $result = \DB::table('guests')
                  ->where('id',$transactionTourDetailID)
                  ->where('is_active',1)
                  ->get();
      if($result){
        return $result;
      }else{
        return 'false';
      }
}
}

