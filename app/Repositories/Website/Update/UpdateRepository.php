<?php 
namespace App\Repositories\Website\Update;

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

class UpdateRepository
{
    public function __construct(Tour $Tour, Configuration_tour_price $Configuration_tour_price, Transaction $Transaction, TransactionTour $TransactionTour, TransactionTourHistory $TransactionTourHistory, TransactionTourDetail $TransactionTourDetail, Guest $Guest, Payment $Payment, InvoiceTour $InvoiceTour, TransactionTourDetailHistory $TransactionTourDetailHistory)
    {
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
    public function getTransactionID($transactionID)
    {
        $result = \DB::table('transactions')
            ->where('id', $transactionID)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    // ---------------- Get Transaction Tour -----------------
    public function getTransactionTour($transactionID)
    {
        $result = \DB::table('transaction_tours')
            ->where('transaction_id', $transactionID)
            ->where('is_active', 1)
            ->where('is_travel', 0)
            ->where('is_cancel', 0)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    // ---------------- Get Transaction Tour Detail -----------------
    public function getTransactionTourDetail($transactionTourID)
    {
        $result = \DB::table('transaction_tour_details')
            ->where('transaction_tour_id', $transactionTourID)
            ->where('is_active', 1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    // ---------------- Insert New Guest (sub) -----------------
    public function insertNewGuest($guestinfo)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');

        $guest = [
            'fullname' => array_get($guestinfo, 'fullname'),
            'is_active' => 1,
            'created_by' => 'Website',
            'created_at' => $dateTimeNow
        ];
        return $this->Guest->insertGetId($guest);
    }

    // ---------------- Insert New Guest @ Tour Detail (sub) -----------------
    public function insertNewTourDetail($transactionTourID, $guestinfo, $guestID)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');

        $guest = [
            'transaction_tour_id' => $transactionTourID,
            'guest_id' => $guestID,
            'fullname' => array_get($guestinfo, 'fullname'),
            'is_active' => 1,
            'created_by' => 'Website',
            'created_at' => $dateTimeNow
        ];
        $result = $this->TransactionTourDetail->insertGetId($guest);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    // ---------------- update New Guest (sub) -----------------
    public function updateGuest($guest_id, $guestinfo)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');

        $guest = [
            'fullname' => array_get($guestinfo, 'fullname'),
            'is_active' => 1,
            'created_by' => 'Website',
            'updated_at' => $dateTimeNow
        ];
        $result = $this->TransactionTourDetail->where('guest_id', $guest_id)->update($guest);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    // ---------------- update New Guest @ Tour Detail (sub) -----------------
    public function updateTourDetail($guest_id, $guestinfo)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');

        $guest = [
            'fullname' => array_get($guestinfo, 'fullname'),
            'is_active' => 1,
            'created_by' => 'Website',
            'updated_at' => $dateTimeNow
        ];
        $result = $this->Guest->where('id', $guest_id)->update($guest);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //---------------- Get Transaction Tour (sub guest) ----------------- 
    public function getTransactionTourDetailGuest($transactionTourID)
    {
        $result = \DB::table('transaction_tour_details')
            ->where('transaction_tour_id', $transactionTourID)
            ->where('is_active', 1)
            ->where('is_primary', 0)
            ->get();
        if ($result) {
            return $result;
        } else {
            return 'false';
        }
    }

    //---------------- Update Guest Primary ----------------- 
    public function updateGuest_primary($transactionTourID, $guestinfo)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');

        $guest = [
            'fullname' => array_get($guestinfo, 'fullname'),
            'is_active' => 1,
            'created_by' => 'Website',
            'updated_at' => $dateTimeNow
        ];
        $result = $this->Guest->where('transaction_tour_id', $transactionTourID)
            ->where('is_primary', 1)
            ->update($guest);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }

    //---------------- Update Transaction Tour Detail Primary ----------------- 
    public function updateTransactionTourDetail_primary($guest_id, $guestinfo)
    {
        $dateTimeNow = Carbon::now('Asia/Bangkok');
        $dateNow = $dateTimeNow->format('Y-m-d');

        $guest = [
            'fullname' => array_get($guestinfo, 'fullname'),
            'is_active' => 1,
            'created_by' => 'Website',
            'updated_at' => $dateTimeNow
        ];
        $result = $this->Guest->where('id', $guest_id)
            ->where('is_primary', 1)
            ->update($guest);
        if ($result) {
            return 'true';
        } else {
            return 'false';
        }
    }
}
