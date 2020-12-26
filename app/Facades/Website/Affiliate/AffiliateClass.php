<?php
namespace App\Facades\Website\Affiliate;

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
use App\Repositories\Website\Affiliate\AffiliateRepository as AffiliateRepo;

class AffiliateClass{

	public function __construct(TransactionRepo $TransactionRepo, AffiliateRepo $AffiliateRepo){
    $this->TransactionRepo = $TransactionRepo;
    $this->AffiliateRepo = $AffiliateRepo;
  }
/* ------------------------------------
    Logic get Tours Price
        1.check ID Account by Token
        2.return check ID AFF
  ------------------------------------ */
  public function checkAffiliateID($data){
    $this->checkAffId = new Transaction;
    $AffId = array_get($data,'Aff_id');
    $checkAffid = $this->AffiliateRepo->checkAffID($AffId);
      if($checkAffid == 'true'){
        $this->checkAffId ->status = 'true';
        return $this->checkAffId ;
      }else{
        $this->checkAffId ->status = 'false';
        return $this->checkAffId ;
      }
  }
  
}